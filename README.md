# 🇲🇦 Portail Web du Haut-Commissariat au Plan (HCP)

Application web dynamique développée en **PHP / MySQL** qui reproduit et modernise le portail du Haut-Commissariat au Plan du Maroc. Elle permet la consultation publique des publications, enquêtes et statistiques, ainsi qu'une **interface d'administration** complète pour gérer tout le contenu du site.

---

## 📌 Présentation

Le projet se compose de deux parties :

- **Site public** : accessible à tous les visiteurs, pour consulter et télécharger les données du HCP.
- **Espace d'administration** : sécurisé par authentification, pour gérer les utilisateurs, les enquêtes, les statistiques, les publications et le contenu du site.

Un **assistant IA (chatbot)** est également intégré pour répondre aux questions des visiteurs sur le HCP.

---

## ✨ Fonctionnalités

### 🌐 Partie publique

| Page | Description |
|------|-------------|
| **Accueil** | Page d'accueil avec présentation du HCP et accès rapide aux publications et statistiques |
| **À propos** | Mission, valeurs et chiffres clés (PIB réel, population, dépenses publiques, inflation) |
| **Institutions** | Présentation du HCP, chiffres clés et domaines d'intervention (démographie, économie, environnement, éducation, social, territoires) |
| **Découvrir** | Carte du Maroc et liste des 12 directions régionales avec accès à leur fiche détaillée |
| **Fiche régionale** | Présentation de la direction, missions, chiffres clés (habitants, croissance, superficie, chômage), localisation Google Maps et liens utiles |
| **Publications** | Liste filtrable (recherche, date, catégorie) avec page de détail et téléchargement |
| **Enquêtes** | Liste des enquêtes avec recherche par mot-clé et par date, téléchargement |
| **Statistiques** | Liste des statistiques filtrable par catégorie, date et mot-clé |
| **Contact** | Formulaire de contact, coordonnées, horaires d'ouverture, carte et réseaux sociaux |
| **Assistant HCP** | Chatbot IA pour obtenir des informations sur le site et l'institution |

### 🔐 Espace d'administration

- **Authentification sécurisée** (connexion, « se souvenir de moi », mot de passe oublié)
- **Tableau de bord** : indicateurs clés (enquêtes, statistiques, publications, utilisateurs, brouillons, téléchargements) et graphiques interactifs (Chart.js)
- **Gestion des utilisateurs** : ajout, modification, suppression, blocage, rôles, export
- **Gestion des enquêtes** : CRUD complet, statuts (en cours, terminée, brouillon), filtres, graphiques de suivi
- **Gestion des statistiques** : par catégorie (Économie, Marché du travail, Développement durable, etc.), données économiques, réseau statistique et données démographiques
- **Gestion des publications** : catégories (Rapports et études, Notes et analyses, Bulletins et revues, Autres documents), compteur de téléchargements
- **Gestion du contenu du site** : directions régionales, description du site, liens des réseaux sociaux
- **Paramètres** : nom du site, email, téléphone, logo et favicon
- **Export** des données

---

## 🛠️ Technologies utilisées

- **Front-end** : HTML5, CSS3, JavaScript
- **Back-end** : PHP
- **Base de données** : MySQL
- **Graphiques** : Chart.js
- **Cartographie** : Google Maps (intégration)
- **Serveur local** : XAMPP
- **IA** : Chatbot intégré (API)

---

## 📁 Structure du projet



---

## 🚀 Installation

1. **Cloner le dépôt**
```bash
   git clone https://github.com/votre-utilisateur/hcp-portail.git
```
2. Placer le dossier dans `htdocs` de **XAMPP** (`C:/xampp/htdocs/Projets_web/Hpc`).
3. Démarrer **Apache** et **MySQL** depuis XAMPP.
4. Créer une base de données dans **phpMyAdmin** et importer le fichier `.sql` fourni.
5. Configurer la connexion à la base dans le fichier de configuration.
6. Accéder au site :
   - Site public : `http://localhost/Projets_web/Hpc/`
   - Administration : `http://localhost/Projets_web/Hpc/pages/login.php`

---

## 🖼️ Aperçu

> Ajoute ici tes captures d'écran dans un dossier `/screenshots`

```markdown
![Accueil](screenshots/Acceuil.PNG)
![Dashboard](screenshots/dashboard-acceuil.PNG)
![Publications](screenshots/publication.PNG)
```

---

## 👤 Auteur

**Ton Nom**
- GitHub : [@ton-pseudo](https://github.com/ton-pseudo)

---

## 📄 Licence

Projet réalisé à but pédagogique. Les logos et contenus appartiennent au Haut-Commissariat au Plan du Maroc.
