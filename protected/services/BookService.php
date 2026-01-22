<?php

class BookService
{
    /**
     * Load Book model with authors by primary key or throw 404.
     *
     * @param int|string $id
     * @return Book
     * @throws CHttpException
     */
    public static function loadModel($id)
    {
        $model = Book::model()->with('authors')->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested book does not exist.');
        }
        return $model;
    }

    /**
     * Build authors list as id => "Last F. M." using a single SQL query.
     *
     * @return array
     */
    public static function buildAuthorsList(): array
    {
        $rows = Yii::app()->db->createCommand("
            SELECT id, CONCAT_WS(' ', last_name, CONCAT(LEFT(first_name,1),'.'), CONCAT(LEFT(middle_name,1),'.')) AS name
            FROM author
            ORDER BY last_name
        ")->queryAll();
        $authorsList = [];
        foreach ($rows as $r) {
            $authorsList[$r['id']] = $r['name'];
        }
        return $authorsList;
    }

    /**
     * Build array of selected author IDs for a Book model.
     *
     * @param Book $model
     * @return array
     */
    public static function buildSelectedAuthors(Book $model): array
    {
        $ids = [];
        foreach ($model->authors as $a) {
            $ids[] = $a->id;
        }
        return $ids;
    }

    /**
     * Update authors for the given Book model using POSTed authors (or provided array).
     *
     * @param Book $model
     * @param array|null $authorIds
     * @return void
     */
    public static function updateBookAuthors(Book $model, ?array $authorIds = null): void
    {
        $ids = $authorIds ?? (isset($_POST['authors']) ? $_POST['authors'] : []);
        self::saveAuthors($model->id, $ids);
    }

    /**
     * Save author relations for a book id.
     *
     * @param int $bookId
     * @param array $authorIds
     * @return void
     */
    protected static function saveAuthors(int $bookId, array $authorIds): void
    {
        $db = Yii::app()->db;
        $db->createCommand()->delete('book_author', 'book_id=:id', [':id' => $bookId]);
        foreach ($authorIds as $authorId) {
            $authorId = (int)$authorId;
            if ($authorId > 0) {
                $db->createCommand()->insert('book_author', ['book_id' => $bookId, 'author_id' => $authorId]);
            }
        }
    }
}

