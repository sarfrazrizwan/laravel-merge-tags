<?php

return [
    
    /*
     * If you need to use prefix with your model keys, if different models have same keys then
     * it get ignored if prefix is true.
     */

    'prefix' => false,

    /*
     * This is attribute name where you model keys will be placed.
     */

    'attribute_name' => env('MERGETAG_ATTRIBUTE', 'data-placeholder')
];
