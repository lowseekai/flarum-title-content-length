<?php

use Flarum\Database\Migration;
use Flarum\Group\Group;

return Migration::addPermissions([
    'litalino-title-content-length.bypassTitle' => Group::MODERATOR_ID,
    'litalino-title-content-length.bypassContent' => Group::MODERATOR_ID,
]);
