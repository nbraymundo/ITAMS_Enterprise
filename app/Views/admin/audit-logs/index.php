<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Audit Logs</h2>

        <p class="text-muted mb-0">

            System Activity History

        </p>

    </div>

</div>

<div class="card shadow-sm">

    <div class="table-responsive">

        <table class="table table-striped table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="170">Date / Time</th>

                    <th width="180">User</th>

                    <th width="170">Module</th>

                    <th width="120">Action</th>

                    <th>Description</th>

                    <th width="130">IP Address</th>

                </tr>

            </thead>

            <tbody>

            <?php if(empty($logs)): ?>

                <tr>

                    <td colspan="6" class="text-center py-5">

                        <i class="bi bi-clock-history display-5 text-secondary"></i>

                        <h5 class="mt-3">

                            No Audit Logs

                        </h5>

                        <p class="text-muted">

                            No activities have been recorded.

                        </p>

                    </td>

                </tr>

            <?php else: ?>

                <?php foreach($logs as $log): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($log['created_at']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($log['full_name'] ?? 'System') ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($log['module']) ?>

                    </td>

                    <td>

                        <?php

                        $badge='secondary';

                        switch($log['action']){

                            case 'CREATE':

                                $badge='success';

                                break;

                            case 'UPDATE':

                                $badge='warning';

                                break;

                            case 'DELETE':

                            case 'DEACTIVATE':

                                $badge='danger';

                                break;

                            case 'LOGIN':

                                $badge='primary';

                                break;

                        }

                        ?>

                        <span class="badge bg-<?= $badge ?>">

                            <?= htmlspecialchars($log['action']) ?>

                        </span>

                    </td>

                    <td>

                        <?= htmlspecialchars($log['description']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($log['ip_address']) ?>

                    </td>

                </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<div class="d-flex justify-content-between align-items-center mt-3">

    <div>

        Showing

        <strong>

            <?= count($logs) ?>

        </strong>

        of

        <strong>

            <?= $paginator->totalRecords() ?>

        </strong>

        records

    </div>

    <nav>

        <ul class="pagination mb-0">

            <li class="page-item <?= $paginator->hasPrevious() ? '' : 'disabled' ?>">

                <a class="page-link"

                   href="?page=<?= $paginator->previousPage() ?>&per_page=<?= $perPage ?>">

                    Previous

                </a>

            </li>

            <?php for($i=1;$i<=$paginator->totalPages();$i++): ?>

            <li class="page-item <?= $i==$paginator->currentPage()?'active':'' ?>">

                <a class="page-link"

                   href="?page=<?= $i ?>&per_page=<?= $perPage ?>">

                    <?= $i ?>

                </a>

            </li>

            <?php endfor; ?>

            <li class="page-item <?= $paginator->hasNext() ? '' : 'disabled' ?>">

                <a class="page-link"

                   href="?page=<?= $paginator->nextPage() ?>&per_page=<?= $perPage ?>">

                    Next

                </a>

            </li>

        </ul>

    </nav>

</div>