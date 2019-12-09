<?php

namespace App\ModuleName;

use App\ModuleName\ModelName;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerName
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function actionName(string $argument): JsonResponse
    {
        if (!preg_match("/^[a-zA-Z0-9]{64}$/", $argument)) {
            return new JsonResponse([
                'code' => 400,
                'result' => [
                    'message' => 'Bad argument'
                ]
            ]);
        }

        $repository = $this->managerRegistry
            ->getManagerForClass(ModelName::class)
            ->getRepository(ModelName::class);

        $model = $repository->findOneBy(['key_in_module' => $argument]);

        if (!$model) {
            return new JsonResponse([
                'code' => 400,
                'result' => [
                    'message' => 'Model not found'
                ]
            ]);
        }

        return new JsonResponse([
            'code' => 200,
            'result' => [
                'value' => $model->getValue()
            ]
        ]);
    }
}