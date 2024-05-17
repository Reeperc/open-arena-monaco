<?php
$t1 = $_POST['t_droite'];
$t2 = $_POST['t_avancer'];
$t3 = $_POST['t_gauche'];
$t4 = $_POST['t_reculer'];

// Récupérer les données envoyées depuis le formulaire
$texte = '// generated by quake, do not modify
unbindall
bind TAB "+scores"
bind ENTER "+button2"
bind ESCAPE "togglemenu"
bind SPACE "+moveup"
bind + "sizeup"
bind - "sizedown"
bind = "sizeup"
bind [ "weapprev"
bind \ "+mlook"
bind ] "weapnext"
bind _ "sizedown"
bind ` "toggleconsole"
bind c "+movedown"
bind ' . $t1 . ' "+moveright"
bind ' . $t3 . ' "+moveleft"
bind ' . $t4 . ' "+back"
bind t "messagemode"
bind ' . $t2 . ' "+forward"
bind ~ "toggleconsole"
bind PAUSE "pause"
bind UPARROW "+forward"
bind DOWNARROW "+back"
bind LEFTARROW "+left"
bind RIGHTARROW "+right"
bind ALT "+strafe"
bind CTRL "+attack"
bind SHIFT "+speed"
bind DEL "+lookdown"
bind PGDN "+lookup"
bind END "centerview"
bind F1 "vote yes"
bind F2 "vote no"
bind F3 "ui_teamorders"
bind F11 "screenshot"
bind MOUSE1 "+attack"
bind MOUSE2 "+strafe"
	    bind MOUSE3 "+zoom"
	    bind MWHEELDOWN "weapnext"
            bind MWHEELUP "weapprev"
            seta g_warningExpire "3600"
            seta g_maxWarnings "3"
            seta g_publicAdminMessages "1"
            seta g_specChat "1"
            seta g_adminMaxBan "2w"
            seta g_adminTempBan "2m"
            seta g_adminNameProtect "1"
            seta g_adminParseSay "1"
            seta g_adminLog "admin.log"
            seta g_admin "admin.dat"
            seta g_floodMinTime "2000"
            seta g_floodMaxDemerits "5000"
            seta g_mappools "0\maps_dm.cfg\1\maps_tourney.cfg\3\maps_tdm.cfg\4\maps_ctf.cfg\5\maps_oneflag.cfg\6\maps_obelisk.cfg\7\maps_harvester.cfg\8\maps_elimination.cfg\9\maps_ctf.cfg\10\maps_lms.cfg\11\maps_dd.cfg\12\maps_dom.cfg\"
            seta g_autonextmap "0"
            seta g_catchup "0"
            seta g_lms_mode "0"
            seta g_runes "0"
            seta g_awardpushing "1"
            seta elimination_ctf_oneway "0"
            seta elimination_nail "0"
            seta elimination_mine "0"
            seta elimination_chain "0"
            seta elimination_plasmagun "200"
            seta elimination_lightning "300"
            seta elimination_railgun "20"
            seta elimination_rocket "50"
            seta elimination_grenade "100"
            seta elimination_shotgun "500"
            seta elimination_machinegun "500"
            seta elimination_activewarmup "5"
            seta elimination_warmup "7"
            seta elimination_roundtime "120"
            seta elimination_grapple "0"
            seta elimination_bfg "0"
            seta elimination_startArmor "150"
            seta elimination_startHealth "200"
            seta g_spawnprotect "500"
            seta g_lagLightning "1"
            seta g_truePing "0"
            seta g_delagHitscan "0"
            seta pmove_float "1"
            seta pmove_msec "11"
            seta pmove_fixed "0"
            seta g_voteMinFraglimit "0"
            seta g_voteMaxFraglimit "0"
            seta g_voteMinTimelimit "0"
            seta g_voteMaxTimelimit "1000"
            seta g_voteGametypes "/0/1/3/4/5/6/7/8/9/10/11/12/"
            seta g_voteBan "0"
            seta g_voteNames "/map_restart/nextmap/map/g_gametype/kick/clientkick/g_doWarmup/timelimit/fraglimit/shuffle/"
            seta g_maxVotes "3"
            seta g_allowVote "1"
            seta g_respawntime "0"
            seta g_filterBan "1"
            seta g_banIPs ""
            seta g_logsync "0"
            seta g_log "games.log"
            seta g_warmup "20"
            seta g_teamForceBalance "0"
            seta g_teamAutoJoin "0"
            seta g_friendlyFire "0"
            seta capturelimit "8"
            seta videoflags "7"
            seta g_maxGameClients "0"
            seta g_doWarmup "0"
            seta sv_fps "20"
            seta sv_maxclients "8"
            seta timelimit "0"
            seta fraglimit "15"
            seta dmflags "0"
            seta com_hunkMegs "128"
            seta com_altivec "0"
            seta com_maxfps "85"
            seta com_blood "1"
            seta com_ansiColor "0"
            seta com_maxfpsUnfocused "0"
            seta com_maxfpsMinimized "0"
            seta com_busyWait "0"
            seta com_introplayed "1"
            seta con_autochat "1"
            seta vm_cgame "2"
            seta vm_game "2"
            seta vm_ui "2"
            seta sv_hostname "noname"
            seta sv_minRate "0"
            seta sv_maxRate "0"
            seta sv_dlRate "100"
            seta sv_minPing "0"
            seta sv_maxPing "0"
            seta sv_floodProtect "1"
            seta sv_dlURL ""
            seta sv_master3 ""
            seta sv_master4 ""
            seta sv_master5 ""
            seta sv_lanForceRate "1"
            seta sv_strictAuth "1"
            seta sv_banFile "serverbans.dat"
            seta con_autoclear "1"
            seta cl_timedemoLog ""
            seta cl_autoRecordDemo "0"
            seta cl_aviFrameRate "25"
            seta cl_aviMotionJpeg "1"
            seta cl_yawspeed "140"
            seta cl_pitchspeed "140"
            seta cl_maxpackets "30"
            seta cl_packetdup "1"
            seta cl_run "1"
            seta sensitivity "5"
            seta cl_mouseAccel "0"
            seta cl_freelook "1"
            seta cl_mouseAccelStyle "0"
            seta cl_mouseAccelOffset "5"
            seta cl_allowDownload "0"
            seta r_inGameVideo "1"
            seta cg_autoswitch "1"
            seta m_pitch "0.022000"
            seta m_yaw "0.022"
            seta m_forward "0.25"
            seta m_side "0.25"
            seta m_filter "0"
            seta j_pitch "0.022"
            seta j_yaw "-0.022"
            seta j_forward "-0.25"
            seta j_side "0.25"
            seta j_up "0"
            seta j_pitch_axis "3"
            seta j_yaw_axis "2"
            seta j_forward_axis "1"
            seta j_side_axis "0"
            seta j_up_axis "4"
            seta cl_maxPing "800"
            seta cl_lanForcePackets "1"
            seta cl_guidServerUniq "1"
            seta cl_consoleKeys "~ ` 0x7e 0x60"
            seta name "UnnamedPlayer"
            seta rate "25000"
            seta snaps "20"
            seta model "sarge"
            seta headmodel "sarge"
            seta team_model "james"
            seta team_headmodel "*james"
            seta g_redTeam ""
            seta g_blueTeam ""
            seta color1 "4"
            seta color2 "5"
            seta handicap "100"
            seta sex "male"
            seta cl_anonymous "0"
            seta cg_predictItems "1"
            seta cl_useMumble "0"
            seta cl_mumbleScale "0.0254"
            seta cl_voipGainDuringCapture "0.2"
            seta cl_voipCaptureMult "2.0"
            seta cl_voipUseVAD "0"
            seta cl_voipVADThreshold "0.25"
            seta cl_voipShowMeter "1"
            seta cl_voip "1"
            seta cg_viewsize "100"
            seta cl_renderer "opengl2"
            seta r_allowExtensions "1"
            seta r_ext_compressed_textures "0"
            seta r_ext_multitexture "1"
            seta r_ext_compiled_vertex_array "1"
            seta r_ext_texture_env_add "1"
            seta r_ext_framebuffer_object "1"
            seta r_ext_texture_float "1"
            seta r_ext_framebuffer_multisample "0"
            seta r_arb_seamless_cube_map "0"
            seta r_arb_vertex_array_object "1"
            seta r_ext_direct_state_access "1"
            seta r_ext_texture_filter_anisotropic "0"
            seta r_ext_max_anisotropy "2"
            seta r_picmip "1"
            seta r_roundImagesDown "1"
            seta r_detailtextures "1"
            seta r_texturebits "0"
            seta r_colorbits "0"
            seta r_stencilbits "8"
            seta r_depthbits "0"
            seta r_ext_multisample "0"
            seta r_overBrightBits "1"
            seta r_ignorehwgamma "0"
            seta r_mode "3"
            seta r_fullscreen "0"
            seta r_noborder "0"
            seta r_customwidth "1600"
            seta r_customheight "1024"
            seta r_customPixelAspect "1"
            seta r_simpleMipMaps "1"
            seta r_subdivisions "4"
            seta r_stereoEnabled "0"
            seta r_greyscale "0"
            seta r_hdr "1"
            seta r_floatLightmap "0"
            seta r_postProcess "1"
            seta r_toneMap "1"
            seta r_autoExposure "1"
            seta r_depthPrepass "1"
            seta r_ssao "0"
            seta r_normalMapping "1"
            seta r_specularMapping "1"
            seta r_deluxeMapping "1"
            seta r_parallaxMapping "0"
            seta r_parallaxMapOffset "0"
            seta r_parallaxMapShadows "0"
            seta r_cubeMapping "0"
            seta r_cubemapSize "128"
            seta r_deluxeSpecular "0.3"
            seta r_pbr "0"
            seta r_baseNormalX "1.0"
            seta r_baseNormalY "1.0"
            seta r_baseParallax "0.05"
            seta r_baseSpecular "0.04"
            seta r_baseGloss "0.3"
            seta r_glossType "1"
            seta r_dlightMode "0"
            seta r_pshadowDist "128"
            seta r_mergeLightmaps "1"
            seta r_imageUpsample "0"
            seta r_imageUpsampleMaxSize "1024"
            seta r_imageUpsampleType "1"
            seta r_genNormalMaps "0"
            seta r_drawSunRays "0"
            seta r_sunlightMode "1"
            seta r_sunShadows "1"
            seta r_shadowFilter "1"
            seta r_shadowBlur "0"
            seta r_shadowMapSize "1024"
            seta r_shadowCascadeZNear "8"
            seta r_shadowCascadeZFar "1024"
            seta r_shadowCascadeZBias "0"
            seta r_ignoreDstAlpha "1"
            seta r_lodCurveError "250"
            seta r_lodbias "0"
            seta r_flares "0"
            seta r_zproj "64"
            seta r_stereoSeparation "64"
            seta r_ignoreGLErrors "1"
            seta r_fastsky "0"
            seta r_drawSun "0"
            seta r_dynamiclight "1"
            seta r_dlightBacks "1"
            seta r_finish "0"
            seta r_textureMode "GL_LINEAR_MIPMAP_LINEAR"
            seta r_swapInterval "0"
            seta r_gamma "1"
            seta r_facePlaneCull "1"
            seta r_railWidth "16"
            seta r_railCoreWidth "6"
            seta r_railSegmentLength "32"
            seta r_anaglyphMode "0"
            seta r_marksOnTriangleMeshes "0"
            seta r_aviMotionJpegQuality "90"
            seta r_screenshotJpegQuality "90"
            seta r_allowResize "0"
            seta r_centerWindow "0"
            seta in_keyboardDebug "0"
            seta in_mouse "1"
            seta in_nograb "0"
            seta in_joystick "0"
            seta joy_threshold "0.150000"
            seta s_volume "0.8"
            seta s_musicvolume "0.25"
            seta s_doppler "1"
            seta s_muteWhenMinimized "0"
            seta s_muteWhenUnfocused "0"
            seta s_useOpenAL "1"
            seta s_alPrecache "1"
            seta s_alGain "1.0"
            seta s_alSources "96"
            seta s_alDopplerFactor "1.0"
            seta s_alDopplerSpeed "9000"
            seta s_alDriver "libopenal.so.1"
            seta s_alInputDevice ""
            seta s_alDevice ""
            seta s_alCapture "1"
            seta ui_ffa_fraglimit "20"
            seta ui_ffa_timelimit "0"
            seta ui_tourney_fraglimit "0"
            seta ui_tourney_timelimit "15"
            seta ui_team_fraglimit "0"
            seta ui_team_timelimit "20"
            seta ui_team_friendly "1"
            seta ui_ctf_capturelimit "8"
            seta ui_ctf_timelimit "30"
            seta ui_ctf_friendly "0"
            seta ui_1fctf_capturelimit "8"
            seta ui_1fctf_timelimit "30"
            seta ui_1fctf_friendly "0"
            seta ui_overload_capturelimit "8"
            seta ui_overload_timelimit "30"
            seta ui_overload_friendly "0"
            seta ui_harvester_capturelimit "20"
            seta ui_harvester_timelimit "30"
            seta ui_harvester_friendly "0"
            seta ui_elimination_capturelimit "8"
            seta ui_elimination_timelimit "20"
            seta ui_ctf_elimination_capturelimit "8"
            seta ui_ctf_elimination_timelimit "30"
            seta ui_lms_fraglimit "20"
            seta ui_lms_timelimit "0"
            seta ui_dd_capturelimit "8"
            seta ui_dd_timelimit "30"
            seta ui_dd_friendly "0"
            seta ui_dom_capturelimit "500"
            seta ui_dom_timelimit "30"
            seta ui_dom_friendly "0"
            seta g_spScores1 ""
            seta g_spScores2 ""
            seta g_spScores3 ""
            seta g_spScores4 ""
            seta g_spScores5 ""
            seta g_spAwards ""
            seta g_spVideos ""
            seta g_spSkill "2"
            seta ui_browserMaster "0"
            seta ui_browserGameType "0"
            seta ui_browserSortKey "4"
            seta ui_browserShowFull "1"
            seta ui_browserShowEmpty "1"
            seta cg_brassTime "2500"
            seta cg_drawCrosshair "4"
            seta cg_drawCrosshairNames "1"
            seta cg_marks "1"
            seta server1 ""
            seta server2 ""
            seta server3 ""
            seta server4 ""
            seta server5 ""
            seta server6 ""
            seta server7 ""
            seta server8 ""
            seta server9 ""
            seta server10 ""
            seta server11 ""
            seta server12 ""
            seta server13 ""
            seta server14 ""
            seta server15 ""
            seta server16 ""
            seta ui_browserOnlyHumans "0"
            seta ui_setupchecked "1"
            seta com_pipefile ""
            seta net_enabled "3"
            seta net_mcast6addr "ff04::696f:7175:616b:6533"
            seta net_mcast6iface ""
            seta net_socksEnabled "0"
            seta net_socksServer ""
            seta net_socksPort "1080"
            seta net_socksUsername ""
            seta net_socksPassword ""
            seta cl_timeNudge "0"
            seta cg_shadows "1"
            seta cg_drawGun "1"
            seta cg_zoomfov "22.5"
            seta cg_fov "90"
            seta cg_gibs "1"
            seta cg_draw2D "1"
            seta cg_drawStatus "1"
            seta cg_drawTimer "0"
            seta cg_drawFPS "0"
            seta cg_drawSnapshot "0"
            seta cg_draw3dIcons "1"
            seta cg_drawIcons "1"
            seta cg_drawAmmoWarning "1"
            seta cg_drawAttacker "1"
            seta cg_drawSpeed "0"
            seta cg_drawRewards "1"
            seta cg_crosshairSize "24"
            seta cg_crosshairHealth "1"
            seta cg_crosshairX "0"
            seta cg_crosshairY "0"
            seta cg_simpleItems "0"
            seta cg_lagometer "1"
            seta cg_railTrailTime "600"
            seta cg_runpitch "0.002"
            seta cg_runroll "0.005"
            seta cg_bobpitch "0.002"
            seta cg_bobroll "0.002"
            seta cg_teamChatTime "3000"
            seta cg_teamChatHeight "0"
            seta cg_forceModel "0"
            seta cg_deferPlayers "1"
            seta cg_drawTeamOverlay "0"
            seta cg_drawFriend "1"
            seta cg_teamChatsOnly "0"
            seta cg_noVoiceChats "0"
            seta cg_noVoiceText "0"
            seta cg_alwaysWeaponBar "0"
            seta cg_hitsound "0"
            seta cg_voipTeamOnly "1"
            seta cg_cyclegrapple "1"
            seta cg_autovertex "0"
            seta cg_cameraOrbitDelay "50"
            seta cg_scorePlums "1"
            seta cg_noTaunt "0"
            seta cg_noProjectileTrail "0"
            seta ui_smallFont "0.25"
            seta ui_bigFont "0.4"
            seta cg_oldRail "0"
            seta cg_oldRocket "1"
            seta cg_leiEnhancement "0"
            seta cg_leiGoreNoise "0"
            seta cg_leiBrassNoise "0"
            seta cg_leiSuperGoreyAwesome "0"
            seta cg_oldPlasma "1"
            seta cg_delag "1"
            seta cg_cmdTimeNudge "0"
            seta cg_projectileNudge "0"
            seta cg_optimizePrediction "1"
            seta cg_trueLightning "0.0"
            seta cg_music ""
            seta cg_fragmsgsize "1.0"
            seta cg_crosshairPulse "1"
            seta cg_differentCrosshairs "0"
            seta cg_ch1 "1"
            seta cg_ch1size "24"
            seta cg_ch2 "1"
            seta cg_ch2size "24"
            seta cg_ch3 "1"
            seta cg_ch3size "24"
            seta cg_ch4 "1"
            seta cg_ch4size "24"
            seta cg_ch5 "1"
            seta cg_ch5size "24"
            seta cg_ch6 "1"
            seta cg_ch6size "24"
            seta cg_ch7 "1"
            seta cg_ch7size "24"
            seta cg_ch8 "1"
            seta cg_ch8size "24"
            seta cg_ch9 "1"
            seta cg_ch9size "24"
            seta cg_ch10 "1"
            seta cg_ch10size "24"
            seta cg_ch11 "1"
            seta cg_ch11size "24"
            seta cg_ch12 "1"
            seta cg_ch12size "24"
            seta cg_ch13 "1"
            seta cg_ch13size "24"
            seta cg_crosshairColorRed "1.0"
            seta cg_crosshairColorGreen "1.0"
            seta cg_crosshairColorBlue "1.0"
            seta cg_weaponBarStyle "0"
            seta cg_weaponOrder "/1/2/4/3/6/7/8/9/5/"
            seta cg_chatBeep "1"
            seta cg_teamChatBeep "1"
            seta cm_playerCurveClip "1"
            seta r_vertexLight "0"
            seta com_zoneMegs "24"
';

// Chemin du fichier où vous voulez enregistrer le texte
$chemin_fichier_local = '/var/www/html/documents_inutiles/q3config.cfg';

//mettre les permissions sur le répertoire pr être sûr BAPPPPTISTEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
//shell_exec("chmod 777 /var/www/html/documents_inutiles/");

// Écriture du texte dans le fichier local
if (file_put_contents($chemin_fichier_local, $texte) !== false) {
    // Connexion SSH
    $connexion = ssh2_connect('195.221.30.1', 22);
    echo "fichier est bien";
    if ($connexion) {
        // Authentification SSH
        if (ssh2_auth_password($connexion, 'rt', 'rt')) {
            // Transfert du fichier via SCP
            $resultat = ssh2_scp_send($connexion, $chemin_fichier_local, '/home/rt/.openarena/baseoa/q3config.cfg');
            if ($resultat) {
                echo "Fichier envoyé avec succès !";
            } else {
                echo "Une erreur s'est produite lors de l'envoi du fichier.";
            }
        } else {
            echo "Échec de l'authentification SSH.";
        }
    } else {
        echo "Échec de la connexion SSH.";
    }
    header("Location: AccueilVisiteurF.php");
} else {
    echo "Une erreur s'est produite lors de l'enregistrement du fichier.";
}
