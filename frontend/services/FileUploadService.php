<?php
/**
 *
 */

namespace frontend\services;


use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * Сервис для загрузки файлов
 *
 * Class FileUploadService
 * @package frontend\services
 */
class FileUploadService
{
    private $rootDirectory = '@frontend/web';
    private $imgDirectory = 'img';

    public function __construct(string $rootDirectory = null, string $imgDirectory = null)
    {
        $this->rootDirectory = ($rootDirectory) ? $rootDirectory : $this->rootDirectory;
        $this->imgDirectory  = ($imgDirectory) ? $imgDirectory : $this->imgDirectory;

        $this->rootDirectory = ($this->checkAlias($this->rootDirectory))
            ? \Yii::getAlias($this->rootDirectory)
            : $this->rootDirectory;
    }

    /**
     * Метод проверяет явлеяется ли директория алиасом
     *
     * @param string $path
     * @return bool
     */
    private function checkAlias(string $path): bool
    {
        return $path[0] === '@';
    }



    /**
     * Метод для загрузки файлов
     *
     * @param $model
     * @param $attribute
     * @param $path
     * @return string|null
     */
    public function upload($model, $attribute, $path): ?string
    {
        $file = UploadedFile::getInstance($model, $attribute);

        if (is_null($file)) {
            return null;
        }

        $fileName = md5(uniqid() . time()) . '.' . $file->extension;
        $webPath  = DIRECTORY_SEPARATOR . $this->imgDirectory . DIRECTORY_SEPARATOR .
            $path . DIRECTORY_SEPARATOR .
            substr($fileName, 0, 2) . DIRECTORY_SEPARATOR .
            substr($fileName, 0, 1);
        $savePath = $this->rootDirectory . $webPath;

        //Если директория не усуществует то она создаётся
        if (!is_dir($savePath)) {
            BaseFileHelper::createDirectory($savePath);
        }

        if ($file->saveAs($savePath . DIRECTORY_SEPARATOR . $fileName)) {
            return $webPath . DIRECTORY_SEPARATOR . $fileName;
        }

        throw new \DomainException(\Yii::t('app', 'File can not be upload'));
    }
}