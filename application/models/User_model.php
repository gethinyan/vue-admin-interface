<?php

class User_model extends CI_Model
{
    const TABLE_NAME = 'va_user';
    // total count
    public $count = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function userList($where, $limit = 10, $offset = 0, $orderBy = 'update_time DESC')
    {
        $this->count = $this->db->where($where)->count_all_results(self::TABLE_NAME);

        return $this->db->select('user_id, user_name, gender, phone, email, address, status, create_time, update_time')
            ->where($where)
            ->order_by($orderBy)
            ->limit($limit, $offset)
            ->get(self::TABLE_NAME)
            ->result_array();
    }

    public function insert($insertData)
    {
        return $this->db->insert(self::TABLE_NAME, $insertData);
    }

    public function update($where, $updateData)
    {
        return $this->db->where($where)->update(self::TABLE_NAME, $updateData);
    }
}
