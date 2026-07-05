<?php
require_once "db.php";

$trips = $conn->query("SELECT * FROM trip ORDER BY user_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>Trip List</title>

    <style>
        :root{
            --primary:#6C5CE7;
            --primary-dark:#5849c2;
            --accent:#00d2ff;
            --success:#00b894;
            --danger:#ff5e6c;
            --warning:#fdbb2d;
            --bg:#f4f6fb;
            --card-bg:#ffffff;
            --text-dark:#2d3436;
            --text-muted:#8395a7;
            --radius:16px;
            --shadow-soft:0 8px 30px rgba(108,92,231,0.08);
            --shadow-hover:0 14px 40px rgba(108,92,231,0.16);
        }

        *{ box-sizing:border-box; }

        body{
            background:
                radial-gradient(circle at 10% 10%, rgba(108,92,231,0.08), transparent 40%),
                radial-gradient(circle at 90% 20%, rgba(0,210,255,0.08), transparent 40%),
                var(--bg);
            font-family:'Inter', sans-serif;
            color:var(--text-dark);
            min-height:100vh;
            padding-bottom:60px;
        }

        h2, h5, label, .modal-title{
            font-family:'Poppins', sans-serif;
        }

        /* ===== Hero header ===== */
        .hero{
            background:linear-gradient(135deg, var(--primary) 0%, #8e7ff0 45%, var(--accent) 100%);
            border-radius:0 0 40px 40px;
            padding:48px 20px 70px;
            margin-bottom:-40px;
            box-shadow:0 10px 40px rgba(108,92,231,0.25);
            position:relative;
            overflow:hidden;
        }
        .hero::before{
            content:"";
            position:absolute;
            width:220px; height:220px;
            background:rgba(255,255,255,0.12);
            border-radius:50%;
            top:-80px; right:-60px;
        }
        .hero::after{
            content:"";
            position:absolute;
            width:140px; height:140px;
            background:rgba(255,255,255,0.10);
            border-radius:50%;
            bottom:-60px; left:5%;
        }
        .hero h1{
            font-family:'Poppins', sans-serif;
            font-weight:700;
            color:#fff;
            font-size:2rem;
            margin:0;
        }
        .hero p{
            color:rgba(255,255,255,0.85);
            margin:6px 0 0;
            font-size:0.95rem;
        }

        /* ===== Cards ===== */
        .glass-card{
            background:var(--card-bg);
            border-radius:var(--radius);
            box-shadow:var(--shadow-soft);
            border:1px solid rgba(108,92,231,0.06);
            padding:32px;
            position:relative;
            z-index:2;
        }

        .section-title{
            font-weight:600;
            font-size:1.25rem;
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:22px;
            color:var(--text-dark);
        }
        .section-title i{
            width:38px; height:38px;
            display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg, var(--primary), var(--accent));
            color:#fff;
            border-radius:10px;
            font-size:0.95rem;
        }

        /* ===== Form ===== */
        .form-label{
            font-weight:500;
            font-size:0.85rem;
            color:var(--text-muted);
            margin-bottom:6px;
        }
        .form-control{
            border-radius:12px;
            border:1.5px solid #e7eaf3;
            padding:11px 14px;
            font-size:0.95rem;
            transition:all .2s ease;
            background:#fbfcff;
        }
        .form-control:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 4px rgba(108,92,231,0.12);
            background:#fff;
        }

        .btn{
            border-radius:12px;
            font-weight:600;
            font-size:0.9rem;
            padding:10px 22px;
            transition:transform .15s ease, box-shadow .15s ease;
            border:none;
        }
        .btn:active{ transform:scale(0.97); }

        .btn-success{
            background:linear-gradient(135deg, var(--success), #55efc4);
            box-shadow:0 6px 18px rgba(0,184,148,0.30);
        }
        .btn-success:hover{
            box-shadow:0 8px 22px rgba(0,184,148,0.42);
            transform:translateY(-1px);
        }

        .btn-warning{
            background:linear-gradient(135deg, var(--warning), #ffd97a);
            color:#7a5b00;
            box-shadow:0 6px 16px rgba(253,187,45,0.30);
        }
        .btn-warning:hover{
            box-shadow:0 8px 20px rgba(253,187,45,0.4);
            transform:translateY(-1px);
            color:#5c4300;
        }

        .btn-danger{
            background:linear-gradient(135deg, var(--danger), #ff8a94);
            box-shadow:0 6px 16px rgba(255,94,108,0.3);
        }
        .btn-danger:hover{
            box-shadow:0 8px 20px rgba(255,94,108,0.42);
            transform:translateY(-1px);
        }

        /* ===== Table ===== */
        .table-wrap{
            overflow-x:auto;
            border-radius:var(--radius);
        }
        table.table{
            margin-bottom:0;
            border-collapse:separate;
            border-spacing:0 10px;
        }
        table.table thead tr{
            background:transparent;
        }
        table.table thead th{
            border:none;
            background:transparent;
            color:var(--text-muted);
            font-weight:600;
            font-size:0.78rem;
            text-transform:uppercase;
            letter-spacing:0.06em;
            padding:0 16px 10px;
        }
        table.table tbody tr{
            background:#fbfcff;
            transition:transform .15s ease, box-shadow .15s ease;
        }
        table.table tbody tr:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 24px rgba(108,92,231,0.10);
        }
        table.table tbody td{
            border:none;
            padding:16px;
            vertical-align:middle;
            font-size:0.92rem;
        }
        table.table tbody tr td:first-child{
            border-top-left-radius:12px;
            border-bottom-left-radius:12px;
            font-weight:600;
            color:var(--primary);
        }
        table.table tbody tr td:last-child{
            border-top-right-radius:12px;
            border-bottom-right-radius:12px;
        }

        .action-btns{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .empty-state{
            text-align:center;
            padding:50px 20px;
            color:var(--text-muted);
        }
        .empty-state i{
            font-size:2.5rem;
            color:var(--primary);
            opacity:0.4;
            margin-bottom:12px;
        }

        /* ===== Modal ===== */
        .modal-content{
            border-radius:20px;
            border:none;
            overflow:hidden;
        }
        .modal-header{
            background:linear-gradient(135deg, var(--primary), var(--accent));
            border:none;
            padding:20px 24px;
        }
        .modal-header .modal-title{
            color:#fff;
            font-size:1.1rem;
            font-weight:600;
        }
        .modal-header .btn-close{
            filter:invert(1) brightness(2);
        }
        .modal-body{
            padding:24px;
        }
        .modal-footer{
            border:none;
            padding:0 24px 24px;
        }

        /* ===== Responsive: tablets ===== */
        @media (max-width: 991.98px){
            .hero{ padding:38px 18px 60px; border-radius:0 0 30px 30px; }
            .hero h1{ font-size:1.7rem; }
            .glass-card{ padding:24px; }
        }

        /* ===== Responsive: phones ===== */
        @media (max-width: 575.98px){
            .hero{ padding:30px 14px 50px; margin-bottom:-30px; }
            .hero h1{ font-size:1.4rem; }
            .hero p{ font-size:0.85rem; }
            .glass-card{ padding:16px; border-radius:14px; }
            .section-title{ font-size:1.05rem; }
            table.table thead{ display:none; }
            table.table, table.table tbody, table.table tbody tr, table.table tbody td{
                display:block;
                width:100%;
            }
            table.table tbody tr{
                margin-bottom:14px;
                padding:12px 14px;
                border-radius:14px;
            }
            table.table tbody td{
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:8px 4px;
                border-bottom:1px solid #eef0f7;
            }
            table.table tbody td:last-child{ border-bottom:none; }
            table.table tbody td::before{
                content:attr(data-label);
                font-weight:600;
                color:var(--text-muted);
                font-size:0.75rem;
                text-transform:uppercase;
                letter-spacing:0.05em;
                margin-right:10px;
            }
            .action-btns{ justify-content:flex-end; width:100%; }
        }

        /* ===== Responsive: very small phones ===== */
        @media (max-width: 380px){
            .btn{ padding:8px 14px; font-size:0.82rem; }
            .hero h1{ font-size:1.25rem; }
        }
    </style>
</head>
<body>

<div class="hero text-center">
    <h1><i class="fa-solid fa-plane-departure me-2"></i>Trip tv Kp ng ahhhhhh 🙂‍↔️</h1>
    <p>Register Hx Trov Tahh Ot Tv Ors Laor NG Knea Ngai 20 until Trip Day (25-26) York Luy Tlai Room And Food</p>
</div>

<div class="container" style="max-width:1000px; position:relative; z-index:2;">

    <div class="glass-card mb-4">
        <div class="section-title"><i class="fa-solid fa-user-plus"></i> Information Traveler</div>

        <form action="insert.php" method="POST">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kleng Ng Write Name U Hov 🫵🏻</label>
                    <input
                        type="text"
                        name="full_name"
                        class="form-control"
                        placeholder="Enter Full Name"
                        required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Ah K'leng Ng Dak Email (can be empty)</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter Email">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phone Number 👉🏻👈🏻</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        placeholder="Enter Phone Number">
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Hov My luv 🫶🏻
                </button>
            </div>
        </form>
    </div>

    <div class="glass-card">
        <div class="section-title"><i class="fa-solid fa-list-check"></i> List Name Mnus Smos 😘</div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="170">Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if($trips && $trips->num_rows > 0): ?>
                    <?php while($row = $trips->fetch_assoc()): ?>

                        <tr>
                            <td data-label="ID"><?= $row['user_id'] ?></td>
                            <td data-label="Full Name"><?= htmlspecialchars($row['full_name']) ?></td>
                            <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                            <td data-label="Phone"><?= htmlspecialchars($row['phone']) ?></td>

                            <td data-label="Action">
                                <div class="action-btns">
                                    <button
                                        class="btn btn-warning btn-sm editBtn"
                                        data-id="<?= $row['user_id'] ?>"
                                        data-name="<?= htmlspecialchars($row['full_name']) ?>"
                                        data-email="<?= htmlspecialchars($row['email']) ?>"
                                        data-phone="<?= htmlspecialchars($row['phone']) ?>">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>

                                    <a href="delete.php?id=<?= $row['user_id'] ?>"
                                       class="btn btn-danger btn-sm delete-btn">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="background:transparent; box-shadow:none;">
                            <div class="empty-state">
                                <i class="fa-solid fa-suitcase-rolling"></i>
                                <p class="mb-0">No trips registered yet.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>

            </table>
        </div>
    </div>

</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="update.php" method="POST">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Trip Information</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="user_id" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="full_name"
                            id="edit_name"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="edit_email"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input
                            type="text"
                            name="phone"
                            id="edit_phone"
                            class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success w-100">
                        <i class="fa-solid fa-check me-1"></i> Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

</body>
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {

        e.preventDefault();

        const url = this.href;

        Swal.fire({
            title: 'Kom jg ban ot 🥺 ? ',
            text: "Hean Tahh Delete u're mnus sava 🙄",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ff5e6c',
            cancelButtonColor: '#8395a7'
        }).then((result) => {

            if(result.isConfirmed){

                Swal.fire({
                    title: "Deleted!",
                    text: "Record deleted successfully.",
                    icon: "success",
                    confirmButtonColor: '#6C5CE7'
                }).then(()=>{
                    window.location.href = url;
                });

            }

        });

    });
});

const modal = new bootstrap.Modal(document.getElementById('updateModal'));

document.querySelectorAll('.editBtn').forEach(btn=>{

    btn.addEventListener('click',function(){

        document.getElementById('edit_id').value=this.dataset.id;
        document.getElementById('edit_name').value=this.dataset.name;
        document.getElementById('edit_email').value=this.dataset.email;
        document.getElementById('edit_phone').value=this.dataset.phone;

        modal.show();

    });

});
</script>
</html>