<?php

namespace App\Constants;

interface TempFile
{
    public const MAX_FILE_SIZE = 30240;

    public const ALLOW_FILE_MIME_TYPES = [
        'jpg,jpeg,png,bmp,tiff',
        'doc,pdf,docx,zip'
    ];

    public const FOLDER_MARATHON_PREVIEW = 'marathon/preview';

    public const FOLDERS = [
        self::FOLDER_MARATHON_PREVIEW
    ];
}
