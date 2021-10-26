<?php

namespace App\Http\Repositories\EventRepository;

use App\Http\Repositories\Repository;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventRepository extends Repository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function addNew($data)
    {
        $this->model->title = $data['title'];
        $this->model->description = $data['description'];
        $this->model->date = $data['date'];
        $this->model->time = $data['time'];
        $this->model->uuid = $data['uuid'];
        return $this->model->save();
    }

    public function getActive()
    {
        return $this->model
            ->where('activity_status', true)
            ->get();
    }

    /**
     * @return Model
     */
    public function deactivateByUuid(string $uuid)
    {
        $event = $this->model->where('uuid', $uuid)->first();
        if (!empty($event)) {
            $event->activity_status = false;
            return $event->save();
        }
    }
}
