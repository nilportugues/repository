<?php
include './vendor/autoload.php';

use PhpDdd\Demo\Domain\User\BirthDate;
use PhpDdd\Demo\Domain\User\User;
use PhpDdd\Demo\Domain\User\UserEmail;
use PhpDdd\Demo\Domain\User\UserId;
use PhpDdd\Demo\Domain\User\UserName;
use PhpDdd\Demo\Infrastructure\Persistence\User\SqlUserRepository;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;
use PhpDdd\Foundation\Domain\Repository\Order;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Infrastructure\Persistence\Repository\Sql\Pdo\PdoSqlRepository;

/*#######################################################################################
 *
 * LOAD THE REPOSITORY FROM SQLITE
 *
 *######################################################################################*/

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("
    CREATE TABLE users (
    user_id CHAR(255) PRIMARY KEY,
    name CHAR(255) NOT NULL,
    email CHAR(255) NOT NULL,
    birthdate DATETIME NOT NULL)
");

$userRepository = new PdoSqlRepository($pdo, new SqlUserRepository());

for ($i=0; $i<=5000; $i++) {
    $user = new User(
        new UserId($i+1),
        new UserName('User #'.$i),
        new UserEmail("user{$i}@example.com"),
        new BirthDate('now -'.rand(10, 50).' years')
    );
    $userRepository->add($user);
}


print_r($userRepository->count());
echo PHP_EOL;

/*#######################################################################################
 *
 * FILTERING, SORTING AND ORDERING
 *
 *######################################################################################*/

//Build filtering criteria
$filter = new Filter();
$filter
    ->must()
    ->greaterThanOrEqual('users.user_id', 1)
    ->ranges(
        'users.birthdate',
        (new DateTime('now - 30 years'))->format('Y-m-d'),
        (new DateTime('now - 20 years'))->format('Y-m-d')
    );

//Build sorting criteria
$sort = new Sort(['users.birthdate'], new Order(Order::ASCENDING));
$sort->andSort(new Sort(['users.user_id'], new Order(Order::DESCENDING)));


//Query the repository given the criteria.
//print_r($userRepository->findBy($filter, $sort));


/*#######################################################################################
 *
 * MAKING USE OF THE PAGINATION
 *
 *######################################################################################*/

print_r($userRepository->findAll(new Pageable(2, 20, $sort, $filter)));
