<?php

declare(strict_types=1);

namespace Shinobi\Orchestration;

use Shinobi\CSR\Csr;
use Shinobi\Modules\Component;

final class Orchestrator
{
    public function __construct(private Csr $csr) {}

    /** Main runtime loop */
    public function run(int $ticks = 5): int
    {
        $modules = $this->csr->get('modules');       // array or ModuleRegistry
        $cognition = $this->csr->get('cognition');   // CognitionSystem instance

        echo "Shinobi v0.1 - Orchestrator starting...\n";

        for ($tick = 1; $tick <= $ticks; $tick++) {
            echo "Tick $tick\n";


            if (empty($modules)) {
                echo "[Orchestrator] No modules loaded, consulting cognition...\n";
                $decision = $cognition()?->tick();
                echo "[Cognition] Decision: $decision\n";
            } else {
                foreach ($modules as $module) {
                    if ($module instanceof Component) {
                        echo "[Orchestrator] Executing module: " . $module->uri() . "\n";
                        // could call $module->execute($csr) if implemented
                    }
                }
            }

            echo "\n";
        }

        echo "Orchestrator finished.\n";
        return 0;
    }
}
