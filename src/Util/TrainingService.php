<?php
namespace App\Util;
use App\Repository\CourseRepository;
class TrainingService
{
    public function __construct(private readonly CourseRepository
                                $courseRepository)
    {
    }
// calcul du coût d'une formation pour un cours donné
    public function getCost(int $id): int {
        $course = $this->courseRepository->find($id);
        if (!$course) {
            throw new \Exception('Course not found');
        }
        if ($course->getDuration() < 5) {
            $cost = 1000 * $course->getDuration();
        }
        else if ($course->getDuration() < 10) {
            $cost = 950 * $course->getDuration();
        } else {
            $cost = 850 * $course->getDuration();
        }
        return $cost;
    }
}