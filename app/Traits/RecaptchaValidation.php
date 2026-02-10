<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

trait RecaptchaValidation
{
    /**
     * Validate reCAPTCHA token for a specific action
     *
     * @param string $token
     * @param string $action
     * @return bool
     * @throws ValidationException
     */
    protected function validateRecaptcha(string $token, string $action = 'DEFAULT'): bool
    {
        // Retrieve environment variables for Google Cloud Project ID and reCAPTCHA Site Key
        $recaptchaKey = config('captcha.sitekey');
        $project = config('services.google.project_id');

        // Create the reCAPTCHA client and project name
        $options = [
            'credentials' => config('services.google.service_account_credentials'),
        ];

        try {
            $client = new RecaptchaEnterpriseServiceClient($options);
            $projectName = $client->projectName($project);

            // Set the event for the reCAPTCHA assessment
            $event = (new Event())
                ->setSiteKey($recaptchaKey)
                ->setToken($token);

            // Create the assessment
            $assessment = (new \Google\Cloud\RecaptchaEnterprise\V1\Assessment())
                ->setEvent($event);

            $response = $client->createAssessment($projectName, $assessment);

            // Check if the token is valid
            if (!$response->getTokenProperties()->getValid()) {
                $invalidReason = InvalidReason::name($response->getTokenProperties()->getInvalidReason());
                Log::error("reCAPTCHA token invalid: $invalidReason");
                return false;
            }

            // Check if the action matches the expected action
            if ($response->getTokenProperties()->getAction() !== $action) {
                Log::error("reCAPTCHA action mismatch. Action: $action and expected action: " . $response->getTokenProperties()->getAction());
                return false;
            }

            // Check the risk score
            $riskScore = $response->getRiskAnalysis()->getScore();
            Log::info("reCAPTCHA risk score for {$action}: {$riskScore}");

            return $riskScore >= config('app.recaptcha.threshold');

        } catch (\Exception $e) {
            Log::error("reCAPTCHA assessment failed for {$action}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate reCAPTCHA token and throw exception if invalid
     *
     * @param string $token
     * @param string $action
     * @throws ValidationException
     */
    protected function validateRecaptchaOrFail(string $token, string $action = 'DEFAULT'): void
    {
        if (!$this->validateRecaptcha($token, $action)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['reCAPTCHA verification failed.'],
            ]);
        }
    }
}
