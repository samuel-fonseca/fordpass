<?php

function storage_path($path = '')
{
    if (isset($_SERVER['LAMBDA_TASK_ROOT'])) {
        return '/tmp/'.$path;
    }

    return app()->storagePath($path);
}
