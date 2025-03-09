# Тестовый проект "Менеджер задач" (RESTful api)

## Установка

```
git clone https://github.com/eonvse/simpleTask
cd simpleTask
cp .env.example .env
```

### Docker ([Laravel Sail](https://laravel.com/docs/11.x/sail#main-content))

```
sail up
sail shell
```

```
composer install && npm install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## api маршруты


  GET|HEAD        api/tasks .............................................TaskController@index
  POST            api/tasks .............................................TaskController@store
  GET|HEAD        api/tasks-grouped-by-status ...........................TaskController@indexGroupedByStatus
  GET|HEAD        api/tasks/{task} ......................................TaskController@show
  PUT|PATCH       api/tasks/{task} ......................................TaskController@update
  DELETE          api/tasks/{task} ......................................TaskController@destroy
  GET|HEAD        api/tasks/{task}/workers ............................. WorkerController@getWorkers
  POST            api/tasks/{task}/workers ............................. TaskController@assignWorker
  DELETE          api/tasks/{task}/workers/{worker} .................... TaskController@removeWorker
  GET|HEAD        api/workers ...........................................WorkerController@index
  POST            api/workers ...........................................WorkerController@store
  GET|HEAD        api/workers/{worker} ..................................WorkerController@show
  PUT|PATCH       api/workers/{worker} ..................................WorkerController@update
  DELETE          api/workers/{worker} ..................................WorkerController@destroy
  POST            api/workers/{worker}/assign-role ..................... WorkerController@assignRole
  DELETE          api/workers/{worker}/remove-role/{roleId} ............ WorkerController@removeRole
