@extends('layouts.menu')
@section('content')
    {{-- content --}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item active">Travaux</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Mes travaux</h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Travail</th>
                                        <th>Reference</th>
                                        <th>Debut de projet</th>
                                        <th>Durée de travail</th>
                                        <th>Fin de travail</th>
                                        <th>Finition</th>
                                        <th>Prix</th>
                                        <th>Montant reçu</th>
                                        <th>Reste à payer</th>
                                        <th style=""></th>
                                        <th style=""></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $a)
                                            <tr>
                                                <td>{{ $a['travail'] }}</td>
                                                <td>{{ $a['reference'] }}</td>
                                                <td>{{ $a['debut'] }}</td>
                                                <td>{{ $a['duree'] }}</td>
                                                <td>{{ $a['fin_travail'] }}</td>
                                                <td>{{ $a['finition'] }}</td>
                                                <td>{{ $a['prix'] }}</td>
                                                <td>{{ $a['recu'] }}</td>
                                                <td>{{ $a['reste'] }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-success" href="{{ route('devis.export',['id' => $a['devi_id']]) }}" style="margin-right: 10px;">
                                                        <i class="fas fa-eye"></i>
                                                        Devis
                                                    </a>
                                                </td>
{{--                                                <td>--}}
{{--                                                    <a class="btn btn-sm btn-primary" href="{{ route('faire.paiment',['id' => $a['achat_id']]) }}" style="margin-right: 10px;">--}}
{{--                                                        <i class="fas fa-eye"></i>--}}
{{--                                                        Faire un paiement--}}
{{--                                                    </a>--}}
{{--                                                </td>--}}
                                                <td>
                                                    <button class="btn btn-sm btn-primary"
                                                            class="btn btn-app parking-link show-modal-on-click"
                                                            style="margin-right: 10px;"
                                                            onclick="modalClick('{{$a['devi_id']}}')">
                                                        <i class="fas fa-eye"></i>
                                                        Faire un paiement
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @error('error')
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h4>{{ $message }}</h4>
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $pagination->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--    popu--}}

    <div id="overlay">
        <div id="popup">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parkingDetailsModalLabel">Payer un devis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeFormPopup()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="devi_id" id="devi_id" value="">
                    <div class="form-group">
                        <label>Montant</label>
                        <input type="number" step="any" class="form-control" name="montant" id="montant">
                        @error('montant')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Reference</label>
                        <input type="text" step="any" class="form-control" name="reference" id="reference">
                        @error('reference')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" step="any" class="form-control" name="date" id="date">
                        @error('date')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-danger">
                        <p id="message"  class="text-danger"></p>
                        <p id="error"  class="text-danger"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="submitPayer()">Payer</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- end popup --}}
    <script async>
        function modalClick(id) {
            console.log(id); // Affiche l'id dans la console
            var devi_id = document.getElementById('devi_id');
            devi_id.value = id;
            document.getElementById('overlay').style.display = 'flex';
        }
        function closeFormPopup(){
            document.getElementById('overlay').style.display = 'none';
        }
        // function validateMontant(montant) {
        //     if (montant.value === "" || montant.value <= 0) {
        //         return false; // Retourne false si le montant est invalide
        //     }
        //     return true; // Retourne true si le montant est valide
        // }
        //
        // function validateDate(date) {
        //     if (date.value === "") {
        //         return false; // Retourne false si aucune date n'est sélectionnée
        //     }
        //     var dateRegex = /^\d{4}-\d{2}-\d{2}$/; // Format YYYY-MM-DD
        //     if (!dateRegex.test(date.value)) {
        //         return false; // Retourne false si le format de la date est incorrect
        //     }
        //     return true; // Retourne true si la date est valide
        // }
        function submitPayer(){
            var reference = document.getElementById('reference');
            var devi_id = document.getElementById('devi_id');
            var montant = document.getElementById('montant');
            var date = document.getElementById('date');
            // if (!validateMontant(montant) ||!validateDate(date)) {
            //     // alert("Veuillez vérifier le montant et la date."); // Affiche un message d'erreur
            //     var error = document.getElementById('error');
            //     error.innerHTML = "Veuillez vérifier le montant et la date.";
            //     return; // Arrête la soumission du formulaire
            // }
            var dataForm = {
                '_token' : '{{ csrf_token() }}',
                'reference' : reference.value,
                'devi_id' : devi_id.value,
                'montant' : montant.value,
                'date' : date.value,
            }
            var jsonData = JSON.stringify(dataForm);
            console.log(jsonData);
            $.ajax({
                url : "{{ route('payer_achat') }}",
                type : "POST",
                data : jsonData,
                contentType: "application/json; charset=utf-8",
                dataType : "json",
                success: function (data){
                    console.log("Succées")
                    closeFormPopup(); // Ferme le popup
                    location.reload();
                },
                // error : function (data){
                //     var messaError = document.getElementById('error');
                //     error.innerHTML = data.error;
                //     console.log("Erreur : "+data.error);
                // }
                error : function (xhr, status, errorThrown){
                    var errorfront = document.getElementById('error');
                    var messaError = document.getElementById('message');
                    // Accédez à la propriété 'error' de l'objet de réponse
                    var message = xhr.responseJSON.message;
                    var errorMessage= xhr.responseJSON.error;
                    if(message == undefined){
                        messaError.innerHTML = errorMessage;
                        console.log("Erreur : " + errorMessage);
                    }else{
                        messaError.innerHTML = message;
                        console.log("Erreur : " + errorMessage);
                    }
                    if(errorMessage == undefined){
                        messaError.innerHTML = message;
                        console.log("Erreur : " + errorMessage);
                    }else{
                        messaError.innerHTML = message;
                        console.log("Erreur : " + errorMessage);
                    }

                }
            });
        }
    </script>
@endsection
