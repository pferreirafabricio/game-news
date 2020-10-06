<?php

use Source\Support\Response;

/**
 * Create a JSON response od the given value
 *
 * @param  mixed $data
 * @return Response
 */
function response($data): Response
{
    return (new Response($data));
}

