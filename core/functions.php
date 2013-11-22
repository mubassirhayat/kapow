<?php

function asset( $path )
{
    return D_ASSETS . DS . $path;
}

function inclusion( $file )
{
    include STYLESHEETPATH . $file;
}