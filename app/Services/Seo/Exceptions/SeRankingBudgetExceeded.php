<?php

namespace App\Services\Seo\Exceptions;

/** Thrown BEFORE a live call that would exceed the run's credit or call budget. */
class SeRankingBudgetExceeded extends SeRankingException {}
