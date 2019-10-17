CREATE TABLE students (
	id integer PRIMARY KEY,
    name VARCHAR(128) NOT NULL ,
	age INT NOT NULL
);

INSERT INTO students (id, name, age) VALUES
(1, 'A', 20),
(2, 'B', 20),
(3, 'C', 20),
(4, 'D', 10)
;

/*
We need to query all the students couples of the same age
the wanted input is:
A - B
A - C
B - C
 */

/* An obvious query will look like */
select t1.id, t2.id, t1.name, t2.name from people t1, people t2 where t1.age = t2.age and t1.id != t2.id;
/*
the result is:
1 - 2 A - B
1 - 3 A - C
2 - 1 B - A <- a duplicate
2 - 3 B - C
3 - 1 C - A <- a duplicate
3 - 2 C - B <- a duplicate

the main difference of original rows from their duplicates is that t1.id is less than t2.id
so we can filter them out by adding
t1.id < t2.id
*/

select t1.id, t2.id, t1.name, t2.name from people t1, people t2 where t1.age = t2.age and t1.id != t2.id and t1.id < t2.id;

/*
1 - 2 A - B
1 - 3 A - C
2 - 3 B - C
 */