<?php

namespace App\Services;

use App\Utils\StringUtils;

class ResourceService extends Service
{
    private $controllerNameSpace = '';
    private $modelNameSpace = '';
    private $serviceNameSpace = '';
    private $controllerStub = '';
    private $modelStub = '';
    private $serviceStub = '';
    private $viewStubPath = '';

    public function __construct()
    {
        $this->controllerNameSpace = 'App\Http\Controllers\Business';
        $this->modelNameSpace = 'App\Models\Business';
        $this->serviceNameSpace = 'App\Services\Business';

        $this->controllerStub = resource_path('stubs') . '/controller.stub';
        $this->modelStub = resource_path('stubs') . '/model.stub';
        $this->serviceStub = resource_path('stubs') . '/service.stub';
        $this->viewStubPath = resource_path('stubs/view');
    }

    /**
     * 获取控制器内容
     * @param $table
     * @param $columns
     * @param $faker
     * @return array|false|string|string[]
     */
    public function getControllerContent($table, $columns, $faker)
    {
        $tableName = $table->menu_code;
        $stub = file_get_contents($this->controllerStub);
        $stub = str_replace('TtgladControllerNamespace', $this->controllerNameSpace, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladServiceNamespace', $this->serviceNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTableComment', $table->menu_name, $stub);
        $stub = str_replace('TtgladView', lcfirst(StringUtils::underscoreToCamelCase($tableName)), $stub);
        $stub = str_replace('TtgladAuthor', $faker->name, $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->dict_value == 'id') {
                continue;
            }
            $modelFields .= "           //字段:" . $column->dict_name . "\n";
            $modelFields .= "           " . '$model->' . $column->dict_value . " = " . '$request->post(\'' . $column->dict_value . "');\n";
        }
        $stub = str_replace('TtgladFill', trim($modelFields, "\n"), $stub);

        return $stub;
    }


    /**
     * 获取model页面内容
     * @param $table
     * @param $columns
     * @param $faker
     * @return array|false|string|string[]
     */
    public function getModelContent($table, $columns, $faker)
    {
        $tableName = $table->menu_code;
        $stub = file_get_contents($this->modelStub);
        $stub = str_replace('TtgladTableComment', $table->menu_name, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTable', $tableName, $stub);
        $stub = str_replace('TtgladAuthor', $faker->name, $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->dict_value == 'id') {
                continue;
            }
            $modelFields .= "        '" . $column->dict_value . "',\t\t\t//" . $column->dict_name . "\n";
        }
        $stub = str_replace('TtgladFillable', trim($modelFields, "\n"), $stub);

        return $stub;
    }

    /**
     * 获取控制器内容
     * @param $table
     * @param $columns
     * @param $faker
     * @return array|false|string|string[]
     */
    public function getServiceContent($table, $columns, $faker)
    {
        $tableName = $table->menu_code;
        $stub = file_get_contents($this->serviceStub);
        $stub = str_replace('TtgladServiceNamespace', $this->serviceNameSpace, $stub);
        $stub = str_replace('TtgladModelNamespace', $this->modelNameSpace, $stub);
        $stub = str_replace('TtgladClass', StringUtils::underscoreToCamelCase($tableName), $stub);
        $stub = str_replace('TtgladTableComment', $table->menu_name, $stub);
        $stub = str_replace('TtgladAuthor', $faker->name, $stub);

        $modelFields = '';
        foreach ($columns as $column) {
            if ($column->dict_value == 'id') {
                continue;
            }
            $modelFields .= "        //查询匹配:" . $column->dict_name . "\n";
            $modelFields .= "        " . 'if ($data->' . $column->dict_value . ") {\n";
            $modelFields .= "           " . ' $model = $model->where(\'' . $column->dict_value . '\', $data->' . $column->dict_value . ");\n";
            $modelFields .= "        }\n";
        }
        $stub = str_replace('TtgladFill', trim($modelFields, "\n"), $stub);

        return $stub;
    }

    /**
     * 获取控制器内容
     * @param $table
     * @param $columns
     * @return array|false|string|string[]
     */
    public function getControllerContentForGen($table, $columns)
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
            $modelFields .= "           //字段: " . $column->column_comment . "\n";
            $modelFields .= "           " . '$model->' . $column->column_name . " = " . '$request->post(\'' . $column->column_name . "');\n";
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
    public function getModelContentForGen($table, $columns)
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
            $modelFields .= "        '" . $column->column_name . "',            //" . $column->column_comment . "\n";
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
    public function getServiceContentForGen($table, $columns)
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
            $modelFields .= "        //查询匹配:" . $column->column_comment . "\n";
            $modelFields .= "        " . 'if ($data->' . $column->column_name . ") {\n";
            $modelFields .= "            " . ' $model = $model->where(\'' . $column->column_name . '\', $data->' . $column->column_name . ");\n";
            $modelFields .= "        }\n";
        }
        $stub = str_replace('TtgladFill', trim($modelFields, "\n"), $stub);

        return $stub;
    }

    /**
     * 获取代码内容
     * @param $viewType
     * @return false|string
     */
    public function getViewForGen($viewType)
    {
        return file_get_contents($this->viewStubPath . '/' . $viewType . '.stub');
    }
}
