<?php
include('app\config\config.php');
include('app\libraries\Database.php');

importProductCSV();
importASMUserAndAgencies();


function importProductCSV()
{
    $filename = APPROOT . '\products.csv';

    $file = fopen($filename, "r");
    $count = 0;
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $count++;

        if ($count > 1) {
            $productCode = $emapData[0];
            $productName = $emapData[1];
            $model = $emapData[2];
            $business = $emapData[3];
            $industry = $emapData[4];
            $productType = $emapData[5];
            $db = new Database();

            createIndustries($db, $industry);

            $db->query("SELECT id FROM industries WHERE name = :name");
            $db->bind(':name', $industry);
            $industryId = $db->single()->id ?? 0;

            createBusiness($db, $business);
            updateProductTypes($db, $productType, $industryId);
            updateProducts($db, $productCode, $productName, $model, $business, $industryId, $productType);
        }
    }
}

function importASMUserAndAgencies()
{
    $filename = APPROOT . '\asm.csv';

    $file = fopen($filename, "r");
    $count = 0;
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $count++;

        if ($count > 1) {
            $userName = $emapData[0];
            $userCode = $emapData[1];
            $business = $emapData[2];
            $channel = $emapData[3];
            $fullName = $emapData[4];
            $agencyName = $emapData[5];
            $province = $emapData[6];

            $db = new Database();
            createChannel($db, $channel);
            createASMERPAccount($db, $userName, $userCode, $fullName, $business, $channel);
            createAgency($db, $agencyName, $province,  $userName);
        }
    }
}

function createBusiness($db, $business)
{
    $query = "INSERT INTO `business_units` (`business_unit_code`, `name`)
    SELECT :business_unit_code, :business_name
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `business_unit_code`, `name`
        FROM `business_units`
        WHERE `business_unit_code`= :business_unit_code and `name` = :business_name
    )
    LIMIT 1";

    $db->query($query);
    $db->bind(':business_unit_code', trim($business));
    $db->bind(':business_name',  trim($business));
    $db->execute();
}

function updateProducts($db, $productCode, $productName, $model, $business, $industryId, $productType)
{
    $db->query("SELECT id FROM business_units WHERE business_unit_code = :business_unit_code");
    $db->bind(':business_unit_code', $business);
    $business_unit_id = $db->single()->id ?? 0;

    $db->query("SELECT id FROM product_types WHERE `name`  = :name and `industry_id` = :industry_id");
    $db->bind(':name', $productType);
    $db->bind(':industry_id', $industryId);
    $product_type_id = $db->single()->id ?? 0;

    $query = "INSERT INTO `products` (`product_code`,`name`, `model`,  `business_unit_id`, `industry_id`, `product_type_id`)
    VALUES (:product_code, :name, :model, :business_unit_id, :industry_id, :product_type_id)";

    $db->query($query);
    $db->bind(':product_code', $productCode);
    $db->bind(':name',  $productName);
    $db->bind(':model',  $model);
    $db->bind(':business_unit_id',  $business_unit_id);
    $db->bind(':industry_id',  $industryId);
    $db->bind(':product_type_id',  $product_type_id);
    $db->execute();
}

function updateProductTypes($db, $productType, $industryId)
{
    // $query = "INSERT INTO `product_types` (`name`,`industry_id`) VALUES (:product_type, :industry_id) ON DUPLICATE KEY UPDATE `id`=LAST_INSERT_ID(`id`), `name`=VALUES(`name`), `industry_id`=VALUES(`industry_id`)";
    $query = "INSERT INTO `product_types` (`name`, `industry_id`)
    SELECT :product_type, :industry_id
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `name`, `industry_id`
        FROM `product_types`
        WHERE `name` = :product_type and industry_id = :industry_id
    )
    LIMIT 1";

    $db->query($query);
    $db->bind(':product_type', $productType);
    $db->bind(':industry_id',  $industryId);
    $db->execute();
}

function createIndustries($db, $industry)
{
    $query = "INSERT INTO `industries` (`name`)
    SELECT :name
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `name`
        FROM `industries`
        WHERE `name` = :name
    )
    LIMIT 1";

    $db->query($query);
    $db->bind(':name', $industry);
    $db->execute();
}

// $data = new Database;
// $this->db->query('SELECT id, name, province FROM agencies WHERE employee_id = :employee_id');

// $this->db->bind(':employee_id', $empId);

// $results = $this->db->resultSet();

// return $results;

function createChannel($db, $channel)
{
    $query = "INSERT INTO `channels` ( `code`, `name`)
    SELECT :code, :name
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `code`, `name`
        FROM `channels`
        WHERE `code`= :code and `name` = :name
    )
    LIMIT 1";

    $db->query($query);
    $db->bind(':code', $channel);
    $db->bind(':name',  $channel);
    $db->execute();
}

function createASMERPAccount($db, $userName, $userCode, $fullName,  $business, $channel)
{
    $db->query("SELECT id FROM business_units WHERE business_unit_code = :business_unit_code");
    $db->bind(':business_unit_code', $business);
    $business_unit_id = $db->single()->id ?? 0;

    $db->query("SELECT id FROM channels WHERE code = :channel");
    $db->bind(':channel', $channel);
    $channel_id = $db->single()->id ?? 0;

    $query = "INSERT INTO `employees` (`user_name`, `password`, `user_code`, `full_name`, `business_unit_id`, `channel_id`, `level_id` )
    SELECT :user_name, :password, :user_code, :full_name, :business_unit_id, :channel_id, :level_id
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `user_name`, `password`, `user_code`, `full_name`, `business_unit_id`, `channel_id`, `level_id`
        FROM `employees`
        WHERE `user_name`= :user_name
    )
    LIMIT 1";

    $password = password_hash(123456, PASSWORD_DEFAULT);

    $db->query($query);
    $db->bind(':user_name', $userName);
    $db->bind(':password', $password);
    $db->bind(':user_code',  $userCode);
    $db->bind(':full_name',  $fullName);
    $db->bind(':business_unit_id', $business_unit_id);
    $db->bind(':channel_id',  $channel_id);
    $db->bind(':level_id', 3);
    $db->execute();
}

function createAgency($db, $agencyName, $province,  $userName)
{
    $db->query("SELECT id FROM employees WHERE user_name = :user_name");
    $db->bind(':user_name', $userName);
    $employee_id = $db->single()->id ?? 0;

    $query = "INSERT INTO `agencies` (`name`, `province`, `employee_id`)
    SELECT :name, :province, :employee_id
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT `name`, `province`, `employee_id`
        FROM `agencies`
        WHERE `name`= :name and `employee_id` = :employee_id
    )
    LIMIT 1";

    $db->query($query);
    $db->bind(':name', $agencyName);
    $db->bind(':province', $province);
    $db->bind(':employee_id',  $employee_id);
    $db->execute();
}
