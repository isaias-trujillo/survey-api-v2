<?php

namespace modules\survey\domain;

use modules\shared\domain\criteria\Criteria;

interface SurveyRepository
{
    function find(Criteria $criteria): Survey;
}