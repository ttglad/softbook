<?php

namespace App\Services;

use App\Utils\StringUtils;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ResourceService extends Service
{
    private $controllerNameSpace = '';
    private $modelNameSpace = '';
    private $serviceNameSpace = '';
    private $controllerStub = '';
    private $modelStub = '';
    private $serviceStub = '';

    public function __construct()
    {
        $this->controllerNameSpace = 'App\Http\Controllers\Business';
        $this->modelNameSpace = 'App\Models\Business';
        $this->serviceNameSpace = 'App\Services\Business';

        $this->controllerStub = resource_path('stubs') . '/controller.stub';
        $this->modelStub = resource_path('stubs') . '/model.stub';
        $this->serviceStub = resource_path('stubs') . '/service.stub';
    }

    /**
     * 获取控制器内容
     * @param $table
     * @param $columns
     * @return array|false|string|string[]
     */
    public function getControllerContent($table, $columns)
    {
        $tableName = $table->table_name;
        $stub = file_get_contents($this->controllerStub);
        $stub = str_replace('TtgladControllerNamespace', $this->controllerNameSpace, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladServiceNamespace', $this->serviceNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTableComment', $table->table_comment, $stub);
        $stub = str_replace('TtgladView', lcfirst(StringUtils::underscoreToCamelCase($tableName)), $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->column_name == 'id') {
                continue;
            }
            $modelFields .= "\t\t\t//查询匹配:" . $column->column_comment . "\n";
            $modelFields .= "\t\t\t" . '$model->' . $column->column_name . " = " . '$request->post(\'' . $column->column_name . "');\n";
        }
        $stub = str_replace('TtgladFill', trim($modelFields, "\n"), $stub);

        return $stub;
    }


    /**
     * 获取model页面内容
     * @param $table
     * @param $columns
     * @return array|false|string|string[]
     */
    public function getModelContent($table, $columns)
    {
        $tableName = $table->table_name;
        $stub = file_get_contents($this->modelStub);
        $stub = str_replace('TtgladTableComment', $table->table_comment, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTable', $tableName, $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->column_name == 'id') {
                continue;
            }
            $modelFields .= "\t\t'" . $column->column_name . "',\t\t\t//" . $column->column_comment . "\n";
        }
        $stub = str_replace('TtgladFillable', trim($modelFields, "\n"), $stub);

        return $stub;
    }

    /**
     * 获取控制器内容
     * @param $table
     * @param $columns
     * @return array|false|string|string[]
     */
    public function getServiceContent($table, $columns)
    {
        $tableName = $table->table_name;
        $stub = file_get_contents($this->serviceStub);
        $stub = str_replace('TtgladServiceNamespace', $this->serviceNameSpace, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTableComment', $table->table_comment, $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->column_name == 'id') {
                continue;
            }
            $modelFields .= "\t\t//查询匹配:" . $column->column_comment . "\n";
            $modelFields .= "\t\t" . 'if ($data->'. $column->column_name . ") {\n";
            $modelFields .= "\t\t\t" . ' $model = $model->where(\'' . $column->column_name . '\', $data->' . $column->column_name . ");\n";
            $modelFields .= "\t\t}\n";
        }
        $stub = str_replace('TtgladFill', trim($modelFields, "\n"), $stub);

        return $stub;
    }
}
