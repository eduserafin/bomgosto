<?php

session_start();
session_destroy();

header('Location: https://csimulador.com.br/');
exit();