<?php

namespace modules\survey\domain;

interface Progressive
{
    function progress(): array;
    function completed() : bool;
}