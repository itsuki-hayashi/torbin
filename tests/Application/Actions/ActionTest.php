<?php

declare(strict_types=1);

namespace Tests\Application\Actions;

use App\Application\Actions\Action;
use App\Application\Actions\ActionPayload;
use DateTimeImmutable;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Tests\TestCase;
use Webmozart\Assert\Assert;

class ActionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testActionSetsHttpCodeInRespond(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        Assert::isInstanceOf($container, ContainerInterface::class);
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class ($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respond(
                    new ActionPayload(
                        202,
                        [
                            'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                        ]
                    )
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        self::assertEquals(202, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testActionSetsHttpCodeRespondData(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        Assert::notNull($container, '$container is null.');
        $logger = $container->get(LoggerInterface::class);

        $testAction = new class ($logger) extends Action {
            public function __construct(
                LoggerInterface $loggerInterface
            ) {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respondWithData(
                    [
                        'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                    ],
                    202
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        self::assertEquals(202, $response->getStatusCode());
    }
}
