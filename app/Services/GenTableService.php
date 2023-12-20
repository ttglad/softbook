<?php

namespace App\Services;

use App\Models\GenTable;
use App\Models\GenTableColumn;
use App\Utils\StringUtils;
use Illuminate\Support\Facades\DB;

class GenTableService extends Service
{
    /**
     * 获取未导入的表名称
     * @param $tableName
     * @param $tableComment
     * @return array
     */
    public function getNotGenTables($tableName, $tableComment): array
    {
        $sql = "SELECT table_name, table_comment, create_time, update_time FROM information_schema.tables ";
        $sql .= "WHERE table_schema = (SELECT database()) ";
        $sql .= "AND table_name NOT LIKE 'qrtz_%' AND table_name NOT LIKE 'gen_%' AND table_name NOT LIKE 'sys_%' ";
//        $sql .= "AND table_name NOT IN (SELECT table_name FROM gen_table) ";
        if (!empty($tableName)) {
            $sql .= "AND LOWER(table_name) LIKE LOWER(CONCAT('%', #{tableName}, '%')) ";
        }
        if (!empty($tableComment)) {
            $sql .= "AND LOWER(table_comment) LIKE LOWER(CONCAT('%', #{tableComment}, '%')) ";
        }
        $sql .= "ORDER BY create_time DESC;";

        return DB::select($sql);
    }

    /**
     * 根据表名获取表信息
     * @param $tableNames
     * @return array
     */
    public function getTableListByNames($tableNames): array
    {
        $sql = "SELECT table_name, table_comment, create_time, update_time FROM information_schema.tables ";
        $sql .= "WHERE table_name NOT LIKE 'qrtz_%' AND table_name NOT LIKE 'gen_%' AND table_schema = (SELECT database()) AND table_name IN(";
        $sql .= "'" . implode("','", $tableNames) . "'";
        $sql .= ");";
        return DB::select($sql);
    }

    /**
     * 根据表名获取列信息
     * @param $tableNames
     * @return array
     */
    public function getTableColumnByName($tableName): array
    {
        $sql = "SELECT column_name, (CASE WHEN (is_nullable = 'no' && column_key != 'PRI') THEN '1' ELSE null END) AS is_required, (CASE WHEN column_key = 'PRI' THEN '1' ELSE '0' END) AS is_pk, ordinal_position AS sort, column_comment, (CASE WHEN extra = 'auto_increment' THEN '1' ELSE '0' END) AS is_increment, column_type ";
        $sql .= "FROM information_schema.columns WHERE table_schema = (SELECT database()) AND table_name = ('" . $tableName . "') ";
        $sql .= "ORDER BY ordinal_position;";
        return DB::select($sql);
    }

    /**
     * 初始化表
     * @param $tableName
     * @param $tableComment
     * @return GenTable
     */
    public function initGenTable($tableName, $tableComment): GenTable
    {
        $gen = new GenTable();
        $className = StringUtils::underscoreToCamelCase($tableName);
        $gen->table_name = lcfirst($className);
        $gen->table_comment = $tableComment;
        $gen->class_name = $className;
        $gen->tpl_category = 'crud';
        $gen->package_name = 'com.ruoyi.system';
        $gen->module_name = 'system';
        $gen->business_name = lcfirst($className);
        $gen->function_name = $tableComment;
        $gen->function_author = 'softbook';
        $gen->gen_type = '1';

        return $gen;
    }

    /**
     * 初始化表
     * @param $tableName
     * @param $tableComment
     * `column_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
     * `table_id` varchar(64) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '归属表编号',
     * `column_name` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '列名称',
     * `column_comment` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '列描述',
     * `column_type` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '列类型',
     * `java_type` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'JAVA类型',
     * `java_field` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'JAVA字段名',
     * `is_pk` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否主键（1是）',
     * `is_increment` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否自增（1是）',
     * `is_required` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否必填（1是）',
     * `is_insert` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否为插入字段（1是）',
     * `is_edit` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否编辑字段（1是）',
     * `is_list` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否列表字段（1是）',
     * `is_query` char(1) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '是否查询字段（1是）',
     * `query_type` varchar(200) COLLATE utf8mb4_bin DEFAULT 'EQ' COMMENT '查询方式（等于、不等于、大于、小于、范围）',
     * `html_type` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL COMMENT '显示类型（文本框、文本域、下拉框、复选框、单选框、日期控件）',
     * `dict_type` varchar(200) COLLATE utf8mb4_bin DEFAULT '' COMMENT '字典类型',
     * `sort` int(11) DEFAULT NULL COMMENT '排序',
     * `create_by` varchar(64) COLLATE utf8mb4_bin DEFAULT '' COMMENT '创建者',
     * `create_time` datetime DEFAULT NULL COMMENT '创建时间',
     * `update_by` varchar(64) COLLATE utf8mb4_bin DEFAULT '' COMMENT '更新者',
     * `update_time` datetime DEFAULT NULL COMMENT '更新时间',
     * @return GenTable
     */
    public function initGenTableColumn($columnObj, $genTable): GenTableColumn
    {
        // 获取字段类型，int，varchar
        $columnDataType = StringUtils::getDbColumnType($columnObj->column_type);

        $column = new GenTableColumn();
        $column->column_name = $columnObj->column_name;
        $column->column_comment = $columnObj->column_comment;
        $column->column_type = $columnObj->column_type;
        $column->is_pk = $columnObj->is_pk;
        $column->is_increment = $columnObj->is_increment;
        $column->is_required = $columnObj->is_required;
        $column->sort = $columnObj->sort;

        $column->table_id = $genTable->table_id;
        $column->create_by = $genTable->create_by;
        $column->java_field = lcfirst(StringUtils::underscoreToCamelCase($column->column_name));
        $column->java_type = 'String';
        $column->query_type = 'EQ';
        $column->html_type = 'input';

        if (in_array($columnDataType, ['tinytext', 'text', 'mediumtext', 'longtext'])) {
            $column->html_type = 'textarea';
        } elseif (in_array($columnDataType, ['datetime', 'time', 'date', 'timestamp'])) {
            $column->java_type = 'Date';
            $column->html_type = 'datetime';
        } elseif (in_array($columnDataType, ['tinyint', 'smallint', 'mediumint', 'int', 'number', 'integer', 'bit'])) {
            $column->java_type = 'Integer';
        } elseif (in_array($columnDataType, ['bigint'])) {
            $column->java_type = 'Long';
        } elseif (in_array($columnDataType, ['float', 'double', 'decimal'])) {
            $column->java_type = 'BigDecimal';
        }

        $column->is_insert = '1';
        if (!in_array($column->column_name, ['id', 'create_by', 'create_time', 'del_flag']) && !$column->is_pk) {
            $column->is_edit = '1';
        }
        if (!in_array($column->column_name, [
                'id',
                'create_by',
                'create_time',
                'del_flag',
                'update_by',
                'update_time'
            ]) && !$column->is_pk) {
            $column->is_list = '1';
        }
        if (!in_array($column->column_name, [
                'id',
                'create_by',
                'create_time',
                'del_flag',
                'update_by',
                'update_time',
                'remark',
            ]) && !$column->is_pk) {
            $column->is_query = '1';
        }

        return $column;
    }
}
