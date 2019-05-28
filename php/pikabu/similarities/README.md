# General

It's still not so accurate, and accuracy gets worse the bigger and granular the DB becomes

### Bootstrap

`docker network create pikabu-network`

`docker-compose up -d`

### To run tests:

`docker exec -it pikabu-php php /var/www/html/job-test.php`

`docker exec -it pikabu-php php /var/www/html/job-test-performance.php`

Currently here is a latest version (master)

First ["normal version"](https://github.com/boryashkin/algorithm-problem-solving/commit/73ad00b35e2018f93b5f582b629b0037f10039e6#diff-42ea94b1fae9e0481e26d9d9ea94d1f1)

Previous ["dummy version"](https://github.com/boryashkin/algorithm-problem-solving/commit/2fc7e4736685ab64580ba2918cbe5d7f1db3b43b)


### Performance in seconds

`Intel i7-8550U`

Latest version (master):

| 1000 inserts  | 1000 searches |
| ------------- | ------------- |
| 4.91          |   0.65        |
| 4.89          |   0.52        |
| 4.83          |   0.43        |
| 4.86          |   0.61        |
| 4.83          |   0.36        |
| 4.82          |   0.78        |

First ["normal version"](https://github.com/boryashkin/algorithm-problem-solving/commit/73ad00b35e2018f93b5f582b629b0037f10039e6#diff-42ea94b1fae9e0481e26d9d9ea94d1f1):

| 1000 inserts  | 1000 searches |
| ------------- | ------------- |
| 5.76          |   1.09        |
| 5.76          |   1.10        |
| 5.78          |   0.50        |
| 5.83          |   0.63        |
| 5.65          |   0.59        |
| 5.66          |   0.84        |
| 5.20          |   0.73        |

First ["dummy version"](https://github.com/boryashkin/algorithm-problem-solving/commit/2fc7e4736685ab64580ba2918cbe5d7f1db3b43b):

| 1000 inserts  | 1000 searches |
| ------------- | ------------- |
| 8.41          |   2.02        |
| 8.10          |   2.10        |
| 7.75          |   2.02        |
| 7.95          |   2.08        |
| 7.17          |   2.20        |


