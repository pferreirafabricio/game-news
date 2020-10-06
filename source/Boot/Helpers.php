<?php

use Source\Support\Response;

function response(array $data): Response
{
    return (new Response($data));
}

