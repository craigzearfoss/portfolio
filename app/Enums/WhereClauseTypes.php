<?php

namespace App\Enums;

enum WhereClauseTypes: string
{
    case BOOL = 'bool';
    case DEFAULT = 'default';   // does exact match
    case INT = 'int';
    case MAX = 'max';
    case MIN = 'min';
    case WILDCARD = 'wildcard';
}
