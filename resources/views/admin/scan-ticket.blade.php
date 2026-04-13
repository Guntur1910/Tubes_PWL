@extends('layouts.admin')

@section('title', 'Scan Ticket')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fa fa-qrcode"></i> Scan Ticket Validation
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Manual Input</h5>
                                </div>
                                <div class="card-body">
                                    <form id="scanForm">
                                        <div class="form-group">
                                            <label for="ticketCode">Ticket Code</label>
                                            <input type="text"
                                                   class="form-control"
                                                   id="ticketCode"
                                                   name="ticket_code"
                                                   placeholder="Masukkan kode tiket (TKT-XXXXXXX)"
                                                   required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search"></i> Validate Ticket
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>QR Code Scanner</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div id="qr-reader" style="width: 100%; max-width: 300px; margin: 0 auto;"></div>
                                    <button id="startScan" class="btn btn-success btn-block mt-3">
                                        <i class="fa fa-camera"></i> Start Camera Scan
                                    </button>
                                    <button id="stopScan" class="btn btn-danger btn-block mt-2" style="display: none;">
                                        <i class="fa fa-stop"></i> Stop Scan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Result Display -->
                    <div id="scanResult" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h5 id="resultTitle">Scan Result</h5>
                            </div>
                            <div class="card-body">
                                <div id="resultContent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;

document.getElementById('scanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const ticketCode = document.getElementById('ticketCode').value.trim();
    if (ticketCode) {
        validateTicket(ticketCode);
    }
});

document.getElementById('startScan').addEventListener('click', function() {
    startQRScan();
});

document.getElementById('stopScan').addEventListener('click', function() {
    stopQRScan();
});

function startQRScan() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
    }

    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader",
        { fps: 10, qrbox: { width: 250, height: 250 } },
        false
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    document.getElementById('startScan').style.display = 'none';
    document.getElementById('stopScan').style.display = 'block';
}

function stopQRScan() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
        html5QrcodeScanner = null;
    }

    document.getElementById('startScan').style.display = 'block';
    document.getElementById('stopScan').style.display = 'none';
}

function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning after successful scan
    stopQRScan();

    // Validate the scanned ticket code
    validateTicket(decodedText);
}

function onScanFailure(error) {
    console.warn(`QR scan error: ${error}`);
}

function validateTicket(ticketCode) {
    // Show loading
    const resultDiv = document.getElementById('scanResult');
    const resultTitle = document.getElementById('resultTitle');
    const resultContent = document.getElementById('resultContent');

    resultTitle.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Validating...';
    resultContent.innerHTML = '';
    resultDiv.style.display = 'block';

    // Send AJAX request
    fetch('{{ route("admin.validate-ticket") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ticket_code: ticketCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            resultTitle.innerHTML = '<i class="fa fa-check-circle text-success"></i> Ticket Valid!';
            resultContent.innerHTML = `
                <div class="alert alert-success">
                    <h6>${data.message}</h6>
                    <hr>
                    <p><strong>Event:</strong> ${data.ticket.transaction.event.name}</p>
                    <p><strong>Ticket Type:</strong> ${data.ticket.transaction.ticket_type.name}</p>
                    <p><strong>Ticket Code:</strong> ${data.ticket.ticket_code}</p>
                    <p><strong>Customer:</strong> ${data.ticket.transaction.user.name}</p>
                </div>
            `;
        } else {
            resultTitle.innerHTML = '<i class="fa fa-times-circle text-danger"></i> Invalid Ticket';
            resultContent.innerHTML = `
                <div class="alert alert-danger">
                    <h6>${data.message}</h6>
                    ${data.ticket ? `
                    <hr>
                    <p><strong>Event:</strong> ${data.ticket.transaction.event.name}</p>
                    <p><strong>Ticket Type:</strong> ${data.ticket.transaction.ticket_type.name}</p>
                    <p><strong>Ticket Code:</strong> ${data.ticket.ticket_code}</p>
                    <p><strong>Status:</strong> ${data.ticket.status}</p>
                    ` : ''}
                </div>
            `;
        }
    })
    .catch(error => {
        resultTitle.innerHTML = '<i class="fa fa-exclamation-triangle text-warning"></i> Error';
        resultContent.innerHTML = `
            <div class="alert alert-warning">
                <h6>Terjadi kesalahan saat validasi tiket</h6>
                <p>Silakan coba lagi atau hubungi administrator.</p>
            </div>
        `;
        console.error('Validation error:', error);
    });
}

// Auto-focus input field
document.getElementById('ticketCode').focus();
</script>
@endsection