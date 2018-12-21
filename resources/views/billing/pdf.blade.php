<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<style> table {font-size: 12px; font-family: Helvetica, Arial, Sans-Serif;} html {font-family: Helvetica, Arial, Sans-Serif;} </style>

<div class="container-fluid">

	<table width="100%" style="margin-bottom: 50px;">
		<tr>
			<td width="50%" class="text-left"><img src="./img/site/kmlogo.jpg" alt="Kodeministeriet logo" height="84" width="312"></td>
			<td width="50%" class="text-left"><h1 class="text-right"><strong>Faktura 12345678</strong></h1></td>
		</tr>
	</table>

	<table width="100%" style="margin-bottom: 50px;">
		<tr>
			<td width="40%" class="text-left"><strong>Kundeoplysninger:</strong></td>
			<td width="40%" class="text-left"><strong></strong></td>
			<td width="20%" class="text-left"><strong></strong></td>
        </tr>
        @if ($ProjectCase->Customer->companyName !== NULL)
        <tr>
            <td width="40%" class="text-left">{{$ProjectCase->Customer->companyName}}</td>
			<td width="40%" class="text-left"><strong></strong></td>
            <td width="20%" class="text-left"><strong></strong></td>
        </tr>
        @endif
		<tr>
			<td width="40%" class="text-left">{{$ProjectCase->Customer->full_name}}</td>
			<td width="40%" class="text-left">Kodeministeriet</td>
			<td width="20%" class="text-left">{{$ProjectCase->Customer->id}}</td>
		</tr>
		<tr>
			<td width="40%" class="text-left">{{$ProjectCase->Customer->Address->street}} {{$ProjectCase->Customer->Address->streetNumber}}</td>
			<td width="40%" class="text-left">Gammel Postvej 10</td>
			<td width="20%" class="text-left">Dato</td>
		</tr>
		<tr>
            <td width="50%" class="text-left">{{$ProjectCase->Customer->Address->zipCode}} {{$ProjectCase->Customer->Address->city}}</td>
			<td width="50%" class="text-left">6720 Fanø</td>
			<td width="20%" class="text-left"></td>
		</tr>
		<tr>
			<td width="40%" class="text-left">{{$ProjectCase->Customer->Address->country}}</td>
			<td width="40%" class="text-left">Danmark</td>
		</tr>
	</table>

	<!-- The below row is all in the order summary -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Ordreinformation</strong></h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<td><strong>Item</strong></td>
									<td class="text-center"><strong>Price</strong></td>
									<td class="text-center"><strong>Quantity</strong></td>
									<td class="text-right"><strong>Totals</strong></td>
								</tr>
							</thead>
							<tbody>
                                @foreach ($ProjectCase->SubCases as $SubCase)
                                    @foreach ($SubCase->Deliverables as $Deliverable)
                                    <tr>
                                        <td>{{$Deliverable->title}}</td>
                                        <td class="text-center">{{$Deliverable->price}},-</td>
                                        <td class="text-center">N/A</td>
                                        <td class="text-right">{{$Deliverable->price}},-</td>
                                    </tr>
                                    @endforeach
                                    @foreach ($SubCase->UserWorksOn as $Worked)

                                        @if($loop->last)
                                        <tr>
                                            <td>Timer:</td>
                                            <td class="text-center">300,-</td>
                                            <td class="text-center">{{$Worked->pivot->sum('hrs')}}</td>
                                            <td class="text-right">{{300 * $Worked->pivot->sum('hrs')}},-</td>
                                        </tr>

								<tr>
									<td class="thick-line"></td>
									<td class="thick-line"></td>
									<td class="thick-line text-center"><strong>Subtotal eksklusiv moms</strong></td>
                                    <td class="thick-line text-right">{{(300 * $Worked->pivot->sum('hrs')) + $Deliverable->sum('price')}},-</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>Total</strong></td>
									<td class="no-line text-right">{{((300 * $Worked->pivot->sum('hrs')) + $Deliverable->sum('price'))*1.25}},-</td>
                                </tr>
                                @endif
                                @endforeach
                            @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>
