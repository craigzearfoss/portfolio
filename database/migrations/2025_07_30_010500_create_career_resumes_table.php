<?php

use App\Models\Career\Resume;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('career_db')->create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date')->nullable();
            $table->tinyInteger('primary')->default(0);
            $table->text('content')->nullable();
            $table->string('doc_url')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'       => 1,
                'name'     => 'PHP/MySQL Web Developer',
                'date'     => '2015-03-19',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/9avg6ve67wnoooxm3jwbx/resume.doc?rlkey=vzkdjqkuxw59nghmcf8d6v2xa&st=kjkb0kxj&dl=0',
                'pdf_url'  => '',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 2,
                'name'     => 'Senior Web Developer',
                'date'     => '2016-11-24',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/n313k7vveguisq3n9wbxf/craigzearfoss.docx?rlkey=3hms59ts6nwy0iqlyyh3bsw7e&st=695lhlbu&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/o7x78isovwo8220144mjz/craigzearfoss.pdf?rlkey=cbg59sg0jdr38qawkuzhtexu3&st=py7h358e&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 3,
                'name'     => 'Senior Full Stack Developer',
                'date'     => '2018-12-05',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/v83yu6f23pjtg37xs86er/craigzearfoss.docx?rlkey=m0d5vu31abn31kqmrrvirphk7&st=eaqvpj67&dl=0',
                'pdf_url'  => '',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 4,
                'name'     => 'Senior Software Engineer',
                'date'     => '2019-07-28',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/aq4rjtcy8lgr4p3fzk2tu/craigzearfoss.docx?rlkey=axj2g2r0blnn3fj0hgnr4zbxe&st=1wbcx7yl&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/3y0gbw5j1oticsvvquc10/craigzearfoss.pdf?rlkey=4mkpm023j61c7wojr10a605na&st=ckevybmz&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],


            [
                'id'       => 5,
                'name'     => 'Senior Software Engineer',
                'date'     => '2020-03-21',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/3pw6ni7jy3ltmfston3ck/craigzearfoss.docx?rlkey=2xrhukvic3x7y1ycsdujyxp11&st=9jdigq2y&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/u38vtuha8j2wp8h86opim/craigzearfoss.pdf?rlkey=uiaz2lfssza7n4eeqil2yvmsr&st=vzze8s4t&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 6,
                'name'     => 'Senior Software Engineer',
                'date'     => '2022-01-13',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/zdivxb8u518v58a9k2swt/craigzearfoss-extended.docx?rlkey=6tjsnn33gmoct7k3kndxquoh8&st=fy0eootp&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/n55xem02slgzhobszsczd/craigzearfoss.docx?rlkey=0wlntvs93fkc38fsdnqmruqd4&st=eh4jrkzo&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 7,
                'name'     => '',
                'date'     => '2023-01-07',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/kczg2cht4jof2ookdrlor/craigzearfoss.docx?rlkey=fx2er17eq8a7gebkq0s4xkrp2&st=xhfr1ab1&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/dw5n5nwybw01i2axjwt3j/craigzearfoss.pdf?rlkey=y1gp5cuykyns4s4m1zk7ldh4o&st=dytodp4m&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 8,
                'name'     => 'Senior Software Engineer',
                'date'     => '2025-06-09',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/p91cze7mplhvqoxyipq4b/craigzearfoss.docx?rlkey=d8df5ops5irfni98hp2pfkhys&st=v77425zc&dl=0',
                'pdf_url'  => '',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 9,
                'name'     => 'Senior Software Engineer',
                'date'     => '2025-06-16',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/eiqyia4ez7stq6pbbiukn/craigzearfoss.docx?rlkey=cpebqb9nkw20pb73yek8g8fyt&st=ggbhhl8f&dl=0',
                'pdf_url'  => '',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 10,
                'name'     => 'Senior Software Engineer [condensed]',
                'date'     => '2025-06-22',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/uv8egj3schs5gixqdflcz/craigzearfoss.docx?rlkey=bwwjtdveev6zc08gkrv6sc07x&st=ay3bkv0u&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/e3rdmwiqwxg7uf443dki6/craigzearfoss.pdf?rlkey=9ltwy0ozz4nigp43h2he41vyw&st=kqsv3eg7&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 11,
                'name'     => 'Senior Software Engineer [streamlined]',
                'date'     => '2025-06-29',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/keqkxhobp6165za6u1nsq/craigzearfoss.docx?rlkey=tkb3q4xeug3jzef68w4spoux1&st=h0zwcdmh&dl=0',
                'pdf_url'  => '',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 12,
                'name'     => 'Senior Full Stack Developer [prettified]',
                'date'     => '2025-07-07',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/37eb5w83od7p2kd1xrn5c/craigzearfoss.docx?rlkey=pnkdwj465jifxahahcnou1e44&st=gesg99x6&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/f8dwiprt5z64npnm3vcj4/craigzearfoss.pdf?rlkey=c424qxaxysdv2c4n80oium6on&st=ftooahy9&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 13,
                'name'     => 'Senior PHP Developer [prettified]',
                'date'     => '2025-07-07',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/7abbsyqyksq666k4s6kt5/craigzearfoss.docx?rlkey=5yrwlx62iu7x3vkn7rhxofgz5&st=tqb1qqqd&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/9wyp4vz3sx59n18e97qg5/craigzearfoss.pdf?rlkey=sh1gp0x99opsy5hbtl3wpojj3&st=apn7djgj&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 14,
                'name'     => 'Front-end Developer [prettified]',
                'date'     => '2025-07-07',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/d9oox29eju592bl3n8dnv/craigzearfoss.docx?rlkey=5zo2txdbiwdnf5ke0k9vgci90&st=3b8qs7rh&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/dk3dc2wrzgo8idx1nr1dh/craigzearfoss.pdf?rlkey=sdu6h9zz5o37sfpfowip431o1&st=vjuux6f3&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 15,
                'name'     => 'Front-end Developer [prettified]',
                'date'     => '2025-07-22',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/ufli4yrqgm4lxxs04ye9f/craigzearfoss.docx?rlkey=irkim5uy3onev4vqjagk2rqsg&st=dwoslofe&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/ng4s9j5vtsi8mij8mtii5/craigzearfoss.pdf?rlkey=pfcarlb0c48inmfacmkp4awx6&st=1tizg3mi&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 16,
                'name'     => 'Senior Full Stack Developer [prettified]',
                'date'     => '2025-07-22',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/ps9dthkbuybfggnszsb4i/craigzearfoss.docx?rlkey=r4fk6ngm8uo43e0e8htc3kxux&st=iz6xdu53&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/e3oqy77h3xdqhkmyu6j1n/craigzearfoss.pdf?rlkey=pb1uemaaqxsgbm4qlw2bzneds&st=4m5pgd76&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 17,
                'name'     => 'Senior PHP Developer [prettified]',
                'date'     => '2025-07-22',
                'primary'  => 0,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/xu90c7e5tqukk9j4b2c80/craigzearfoss.docx?rlkey=t247wae4z5i4a7j4qix68f6pl&st=iv9stw8u&dl=0',
                'pdf_url'  => 'https://www.dropbox.com/scl/fi/gju304enbljza2335iy74/craigzearfoss.pdf?rlkey=4dgkal9vo2pxazb7af33sbans&st=kk5de6vn&dl=0',
                'public'   => 0,
                'admin_id' => 2,
            ],
            [
                'id'       => 18,
                'name'     => 'Senior Software Engineer [prettified]',
                'date'     => '2025-08-07',
                'primary'  => 1,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/j7v3olr0dzg35j48p40sn/Craig-Zearfoss_full-stack-developer_20250807.docx?rlkey=b8188h0z70fh7an91wm6jv9nv&st=xearhvb7&dl=0',
                'pdf_url'  => '',
                'public'   => 1,
                'admin_id' => 2,
            ],
            [
                'id'       => 19,
                'name'     => 'Full Stack Developer [prettified]',
                'date'     => '2025-08-07',
                'primary'  => 1,
                'doc_url'  => 'https://www.dropbox.com/scl/fi/er3u1zc1342ovlcqq56wk/Craig-Zearfoss_senior-software-engineer_20250807.docx?rlkey=yjuhqc9v2l6voemsm0uu4ily2&st=e0ce63v7&dl=0',
                'pdf_url'  => '',
                'public'   => 1,
                'admin_id' => 2,
            ],
        ];

        Resume::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('resumes');
    }
};
