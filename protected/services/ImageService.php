<?php

class ImageService
{
    /**
     * Prepare uploaded image: set image_url and imageFile on the model if a file was uploaded.
     *
     * @param Book $model
     * @return void
     */
    public static function prepareImageUpload(Book $model): void
    {
        $uploaded = CUploadedFile::getInstance($model, 'imageFile');
        if ($uploaded) {
            $uploadPath = Yii::app()->params['commonSettings']['files']['uploadsPath'];
            $filename = time() . '_' . uniqid() . '.' . $uploaded->extensionName;
            $model->image_url = $uploadPath . $filename;
            $model->imageFile = $uploaded;
        }
    }

    /**
     * Finalize uploaded image after model is saved: move the uploaded file and remove old image if provided.
     *
     * @param Book $model
     * @param string|null $oldImage
     * @return void
     */
    public static function finalizeImageUpload(Book $model, ?string $oldImage = null): void
    {
        if (!empty($model->imageFile)) {
            $savePath = Yii::getPathOfAlias('webroot') . $model->image_url;
            $model->imageFile->saveAs($savePath);
            if (!empty($oldImage) && $oldImage !== $model->image_url) {
                $oldPath = Yii::getPathOfAlias('webroot') . $oldImage;
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }
    }
}

