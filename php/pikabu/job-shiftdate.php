<?php

function shiftDate(string $date): string {
    return (new class($date) extends DateTime {
        public function __invoke() {
            return (func_num_args() === 0 ? $this->format('Y-m-d') : @$this->modify(func_get_arg(0))) ?: $this;
        }
    })
    ('last day of this month')
    ('Monday')
    ('- 4 days')
    ();
}

var_dump(
    shiftDate("2018-07-19"),
    shiftDate("2015-12-20"),
    shiftDate("2020-01-31"),
    shiftDate("2018-07-19") === "2018-08-02"
    && shiftDate("2015-12-20") === "2015-12-31"
    && shiftDate("2020-01-31") === "2020-01-30"
    && shiftDate("2019-08-31") === "2019-08-29"
);