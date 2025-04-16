<?php

namespace App\Interfaces\Model\TextTemplate;

use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasTextInterface;

interface TextTemplateInterface extends HasAdminIdInterface, HasTextInterface, HasStatusInterface
{
    const TABLE = 'text_templates';
}
