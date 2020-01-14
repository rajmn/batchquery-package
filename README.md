
# Batch query for laravel (BULK Query)

## This will help user to execute the batch(bulk) query in their laravel projects.
[![Latest Stable Version](https://poser.pugx.org/rajbatch/batchquery/v/stable)](https://packagist.org/packages/rajbatch/batchquery)
[![License](https://poser.pugx.org/rajbatch/batchquery/license)](https://packagist.org/packages/rajbatch/batchquery)
[![Total Downloads](https://poser.pugx.org/rajbatch/batchquery/downloads)](https://packagist.org/packages/rajbatch/batchquery)
[![Daily Downloads](https://poser.pugx.org/rajbatch/batchquery/d/daily)](https://packagist.org/packages/rajbatch/batchquery)

1. Easy to Install.
2. Easy to execute.
3. Consume very little space, so your project does not get heavy

## 1. Install
  `composer require rajbatch/batchquery`


# **************Batch(bulk) UPDATE*******************
   #### Important parameter needs to be set
   ```php 
    1. $table = "your table name where update";
    2. $index = 'user_id';  // (NOTE: $index field must exist in the $data array. 
                            //  $index performs like WHERE clause to identify
                            //  where needs to update the given value  )
                                 
    3. $set   = ['column1','column2];  // (column name to update)
    4. $data  = [
            [
                'user_id'=>1,
                'column1'  =>'column1_value',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>2,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>3,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
        ];
  ```
### 2. Controller
 ```php 
 use Rajbatch\Batchquery\Batchquery;
 ```

  ### 3. In Controller function
  ```php 
        $batch = new Batchquery();
        $table = "your table name where update";
        $index = 'user_id';
        $set   = ['column1'];
        $data  = [
            [
                'user_id'=>1,
                'column1'  =>'column1_value',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>2,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>3,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
        ];
        $response = $batch->batchUpdate($index,$table,$set,$data);
   ```
   
   # **************Batch(bulk) INSERT*******************
   #### Important parameter needs to be set
   ```php 
    1. $table = "your table name where insert";
    2. $data  = [
            [
                'user_id'=>1,
                'column1'  =>'column1_value',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>2,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>3,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
        ];
  ```
  ### 2. Controller
 ```php 
 use Rajbatch\Batchquery\Batchquery;
 ```

  ### 3. In Controller function
  ```php 
        $batch = new Batchquery();
        $table = "your table name where insert";
        $data  = [
            [
                'user_id'=>1,
                'column1'  =>'column1_value',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>2,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
            [
                'user_id'=>3,
                'column1'  =>'column1',
                'column2'  =>'column2_value'
            ],
        ];
        $response = $batch->batchInsert($table,$data);
   ```
   
