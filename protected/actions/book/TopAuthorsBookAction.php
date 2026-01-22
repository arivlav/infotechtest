<?php

class TopAuthorsBookAction implements IControllerAction
{
    public function execute(?int $id = null): array
    {
        $year = $this->getYear();
        
        $sql = "
            SELECT 
                a.id,
                TRIM(CONCAT_WS(' ',
                    a.last_name,
                    CONCAT_WS('.',
                        IF(a.first_name IS NOT NULL AND a.first_name != '', LEFT(a.first_name, 1), NULL),
                        IF(a.middle_name IS NOT NULL AND a.middle_name != '', LEFT(a.middle_name, 1), NULL)
                    )
                )) as full_name,
                COUNT(DISTINCT ba.book_id) as book_count
            FROM author a
            INNER JOIN book_author ba ON a.id = ba.author_id
            INNER JOIN book b ON ba.book_id = b.id
            WHERE b.year = :year
            GROUP BY a.id, a.last_name, a.first_name, a.middle_name
            ORDER BY book_count DESC, a.last_name ASC
            LIMIT 10
        ";
        
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':year', $year);
        $authors = $command->queryAll();
        
        return [
            'authors' => $authors,
            'year' => $year,
        ];
    }

    private function getYear(): int
    {
        return isset($_GET['year']) && is_numeric($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
    }
}
