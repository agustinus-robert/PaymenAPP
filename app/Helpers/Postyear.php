<?php

function getTemplateByPeriod($salaryTemplates, $period)
{
    return $salaryTemplates->whereDate('start_at', '<=', $period)->whereDate('end_at', '>=', $period);
}
