# **Réflexion base de donnée**

# Les différentes tables 

## Table user

    - username, password, roles, borderline(boolean), created_at

## Table sanction

    - Relation avec un user, sanction, motif, created_at, updated_at, end_time

## Table application (candidature)

    - relation avec comment, name, post, content

## Table comment(commentaire)

    - Relation avec candidature,  relation avec user, content

## Table action (dans un premier temps elle devrait servir pour les users borderlines, pour appliquer des mesures 'correctives' envers un utilisateur précis)

    - action, description

(idée clay :  pouvoir modifier le guide de la modération)
## Table guide ( pour pouvoir modifier le guide de la modération. (à voir) )

    - title (titre d'une section)
    - content (contenu d'un section)

    l'ensemble de plusieurs sections formerons le guide en entier.

