<?php

namespace App\Interfaces\Model\MediaFiles;

use App\Interfaces\Traits\HasNameInterface;
use App\Interfaces\Traits\HasPathInterface;
use App\Interfaces\Traits\HasRelatedIdInterface;
use App\Interfaces\Traits\HasRelatedTypeInterface;
use App\Interfaces\Traits\HasSizeInterface;
use App\Interfaces\Traits\HasTypeInterface;

interface MediaFileInterface extends HasNameInterface, HasPathInterface, HasTypeInterface, HasSizeInterface, HasRelatedTypeInterface, HasRelatedIdInterface
{
    const TABLE = 'media_files';

    public function related(): \Illuminate\Database\Eloquent\Relations\MorphTo;

}
