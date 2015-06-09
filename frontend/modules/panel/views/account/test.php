<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
print_r($model['updated_at']);
echo '<br>';
print_r(time());
echo '<br>';
print_r(time()-$model['updated_at'] <=85000);

