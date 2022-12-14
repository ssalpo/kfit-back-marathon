<?php

namespace App\Services;

use App\Constants\TempFile;
use App\Models\Broadcast;
use App\Models\Marathon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MarathonService
{
    public function __construct(
        private TempFileService $tempFileService,
        private MarathonComponentService $marathonComponentService
    )
    {
    }

    /**
     * Add new marathon
     *
     * @param array $data
     * @return Marathon
     */
    public function store(array $data): Marathon
    {
        return DB::transaction(function () use ($data) {
            $marathon = Marathon::create($data);

            if ($marathon->preview) {
                $this->tempFileService->moveFromTmpFolder(TempFile::FOLDER_MARATHON_PREVIEW, $marathon->preview);
            }

            if ($trainers = Arr::get($data, 'trainers', [])) {
                $marathon->trainers()->sync(
                    array_map(static fn($trainer) => ['trainer_id' => $trainer], $trainers,)
                );
            }

            $broadcast = Broadcast::create();

            $this->marathonComponentService->addBroadcast(
                $marathon->id,
                $broadcast->id
            );

            $marathon->load('trainers', 'broadcast');

            return $marathon;
        });
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
        $marathon = Marathon::with('trainers', 'components')->findOrFail($id);

        $oldPreview = $marathon->preview;

        $isPreviewChanged = $marathon->preview !== Arr::get($data, 'preview');

        $marathon->update($data);

        if ($trainers = Arr::get($data, 'trainers', [])) {
            $marathon->trainers()->sync(
                array_map(static fn($trainer) => ['trainer_id' => $trainer], $trainers,)
            );
        }

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
