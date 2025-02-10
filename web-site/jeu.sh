SSH_OPTIONS="-o StrictHostKeyChecking=no"


sshpass -p 'joueur' ssh -t $SSH_OPTIONS joueur@195.221.30.2 << INNER_EOF &
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27961
INNER_EOF

sshpass -p 'rt' ssh -t $SSH_OPTIONS rt@195.221.30.1 << EOF
export DISPLAY=:0
openarena +set cl_renderer opengl1 +set r_mode -1 +set r_customwidth 1280 +set r_customheight 720 +r_fullscreen 1 +connect 195.221.30.65:27961
EOF

