# Projet de Fin d'Année - Championnat de Quake Français

## Contexte du Projet
Ce site a été conçu dans le cadre d'un projet de fin d'année par un groupe de 6 étudiants. Le projet était à but éducatif.

### Outils utilisés
- Serveur DNS configuré
- Raspberry pi
- Serveur de jeu
- Serveur web
- Serveur de messagerie
- Active Directory

### Description
Le projet simule un Championnat de Quake Français entre les villes suivantes : Rouen, Lille, Paris et Monaco. Notre équipe représente les arènes de Monaco. Nous avons configuré un réseau local comprenant différents serveurs pour permettre aux joueurs de s'affronter. Les deux meilleurs champions de chaque ville affronteront ensuite les finalistes des autres villes.


### Fonctionnalités du Site
La page de connexion permet d'accéder à trois types de sessions :

#### Administrateur
- Voir l'état du serveur de jeu local et des autres villes.
- Récupérer et consulter des backups des serveurs/configurations des routeurs et switchs.

#### Organisateur
- Organiser des tournois et consulter leur historique.
- Lancer des parties avec des modes spécifiques.
- Fermer le serveur de jeu.
- Ajouter ou retirer des bots.
note : un serveur de messagerie a été mis en place, et l'envoi de mails pour prévenir les joueurs d'un début de partie a été automatisé.

#### Joueur
- Voir les modes de jeu triés par type de carte (map du jeu).
- Configurer les touches pour jouer.
- Consulter les règles du jeu.
- Suivre l'avancement du tournoi.

### Accessibilité
Les opérations de connexion étant directement liées à l'Active Directory d'un serveur local, le site ne sera accessible qu'en mode visiteur en dehors du réseau local de jeu.

## Installation (inutile mais bon)
**Cloner le Répertoire**
   ```bash
   git clone https://github.com/Reeperc/open-arena-monaco
