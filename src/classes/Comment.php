<?php

namespace netvod\classes;


use netvod\database\ConnectionFactory;
use netvod\Exceptions\CommentException;

class Comment
{

    public static function addComment(int $id_user, int $id_serie, string $commentaire, int $note): void
    {
        if (self::alreadyComment($id_user, $id_serie)) {
            throw new CommentException('Vous avez déjà commenté cette série');
        } else {
            $db = ConnectionFactory::makeConnection();
            $stmt = $db->prepare('INSERT INTO notation VALUES (?, ?, ?, ?)');
            $stmt->execute([$id_user, $id_serie, $commentaire, $note]);
        }
    }


    public static function alreadyComment(int $id_user, int $id_serie): bool
    {
        $db = ConnectionFactory::makeConnection();

        $stmt = $db->prepare('SELECT * FROM notation WHERE id_user = ? and id_serie = ?');
        $stmt->execute([$id_user, $id_serie]);
        $comment = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($comment) {
            return true;
        }
        return false;

    }
}
