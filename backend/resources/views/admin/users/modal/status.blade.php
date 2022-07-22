<!-- Deactivate -->
<div class="modal fade" id="deactivate-user-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-user-slash"></i> Deactivate User
                </h3> 
            </div>
            <div class="modal-body">
                Are you sure you want to deavtivate <span class="fw-solid">{{ $user->name }}</span>
            </div>
            <div class="modal-footer border-0">
                <form action="" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Deactive</button>
                </form>
            </div>
        </div>
    </div>
</div>