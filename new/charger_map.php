<?php 
function charger_map($map) {
    shell_exec("/var/www/html/open_arena_equipe_4/new/fichier.sh 195.221.30.1 123 map $map");
}