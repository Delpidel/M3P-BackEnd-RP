<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Http\Services\PaginationInstructorService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationInstructorServiceTest extends TestCase
{
    /** @test */
    public function it_paginates_query_results()
    {
        $queryMock = $this->getMockBuilder(Builder::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $queryMock->expects($this->once())
                  ->method('paginate')
                  ->with(
                      $this->equalTo(10),
                      $this->equalTo(['*']),
                      $this->equalTo('page'),
                      $this->equalTo(null)
                  )
                  ->willReturn(new LengthAwarePaginator([], 0, 10));

        $service = new PaginationInstructorService();

        $result = $service->paginate($queryMock, 10, ['*']);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
