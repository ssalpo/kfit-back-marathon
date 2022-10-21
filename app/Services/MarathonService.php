<?php

namespace App\Services;

use App\Constants\TempFile;
use App\Models\Marathon;
use Illuminate\Support\Arr;

class MarathonService
{
    private TempFileService $tempFileService;

    public function __construct(TempFileService $tempFileService)
    {
        $this->tempFileService = $tempFileService;
    }

    /**
     * Add new marathon
     *
     * @param array $data
     * @return Marathon
     */
    public function store(array $data): Marathon
    {
        $marathon = Marathon::create($data);

        if ($marathon->preview) {
            $this->tempFileService->moveFromTmpFolder(TempFile::FOLDER_MARATHON_PREVIEW, $marathon->preview);
        }

        $marathon->trainers()->sync(Arr::get($data, 'trainers', []));

        return $marathon;
    }

    /**
     * Update marathon info
     *
     * @param int $id
     * @param array $data
     * @return Marathon
     */
    public function update(int $id, array $data): Marathon
    {
        $marathon = Marathon::findOrFail($id);

        $oldPreview = $marathon->preview;

        $isPreviewChanged = $marathon->preview !== Arr::get($data, 'preview');

        $marathon->update($data);

        $marathon->trainers()->sync(Arr::get($data, 'trainers', []));

        if ($isPreviewChanged) {
            $this->tempFileService->moveFromTmpFolder(TempFile::FOLDER_MARATHON_PREVIEW, $marathon->preview);

            if ($oldPreview) {
                $this->tempFileService->removeFileFromFolder(TempFile::FOLDER_MARATHON_PREVIEW, $oldPreview);
            }
        }

        return $marathon->refresh();
    }

    /**
     * Remove marathon by ID
     *
     * @param int $id
     * @return Marathon
     */
    public function delete(int $id): Marathon
    {
        $marathon = Marathon::findOrFail($id);

        $marathon->delete();

        return $marathon;
    }
}
