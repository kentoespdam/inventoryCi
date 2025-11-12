<?php

namespace App\Models\Schema;

use CodeIgniter\Model;

class InfoSchemaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'information_schema_tables';
    protected $returnType       = 'object';
}
