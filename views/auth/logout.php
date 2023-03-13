<?php
session_start();
session_destroy();
header('Location: ' .$this->url('login'));