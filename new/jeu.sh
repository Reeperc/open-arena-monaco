if ! systemctl is active --quiet openarena-server.service
then
    echo "Le service n'est pas encore lance"
    sudo systemctl restart openarena-server
else
    echo "Le service est déjà lancé"
fi

ssh joueur@195.221.30.2 << INNER_EOF &
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27960
INNER_EOF

ssh rt@195.221.30.1 << EOF
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27960

EOF