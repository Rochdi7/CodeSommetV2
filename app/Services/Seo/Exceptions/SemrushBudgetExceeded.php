<?php

namespace App\Services\Seo\Exceptions;

/** Thrown BEFORE a live call that would exceed the run's unit or call budget. */
class SemrushBudgetExceeded extends SemrushException {}
