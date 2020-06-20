<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document View</title>
</head>
<body>
<div class="container">

    <a class="btn btn-dark" href="{{ route('create') }}">Generate new competition</a>

    @if(count($divisionA) == 0)
        <h1>Nothing to show here yet!</h1>
    @else

        <div class="row text-center division_A">
            <h2>Division A</h2>
            <table class="table table-dark table-bordered">
                <tr>
                    <th>Team</th>
                    @foreach($divisionA as $team)
                        <th>{{ $team->name }}</th>
                    @endforeach
                    <th>Points</th>
                </tr>
                @foreach($divisionA as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        @for($i = 0; $i < count($divisionA); $i++)
                            @if($team->id == $divisionA[$i]->id)
                                <td>X</td>
                            @else
                                <td>{{ $team->result($team->id, $divisionA[$i]->id) }}</td>
                            @endif
                        @endfor
                        <td>{{ $team->points }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row text-center division_B">
            <h2>Division B</h2>
            <table class="table table-dark table-bordered">
                <tr>
                    <th>Team</th>
                    @foreach($divisionB as $team)
                        <th>{{ $team->name }}</th>
                    @endforeach
                    <th>Points</th>
                </tr>
                @foreach($divisionB as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        @for($i = 0; $i < count($divisionB); $i++)
                            @if($team->id == $divisionB[$i]->id)
                                <td>X</td>
                            @else
                                <td>{{ $team->result($team->id, $divisionB[$i]->id) }}</td>
                            @endif
                        @endfor
                        <td>{{ $team->points }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row playoff">
            <div class="col-md-2 playoff">
                {{ $playoffDivisionA[0]->name }} VS {{ $playoffDivisionB[3]->name }}<br>
                {{ $playoffDivisionA[1]->name }} VS {{ $playoffDivisionB[2]->name }}<br><br>
                {{ $playoffDivisionA[2]->name }} VS {{ $playoffDivisionB[1]->name }}<br>
                {{ $playoffDivisionA[3]->name }} VS {{ $playoffDivisionB[0]->name }}
            </div>
            <div class="col-md-2 semi-final">
                {{ $semiFinal[0]->team->name }} VS {{ $semiFinal[1]->team->name }}<br>
                {{ $semiFinal[2]->team->name }} VS {{ $semiFinal[3]->team->name }}
            </div>
            <div class="col-md-2 final">
                {{ $final[0]->team->name }} VS {{ $final[1]->team->name }}
            </div>
            <div class="col-md-3 champion">
                {{ $champion[0]->name }} is the champion!
            </div>
            <div class="col-md-3">
                <table class="table table-dark table-bordered">
                    <tr>
                        <th>Team</th>
                        <th>Position</th>
                        <th>Total points</th>
                    </tr>
                    @for($i = 0; $i < count($results); $i++)
                        <tr>
                            <td>{{ $results[$i]->name }}</td>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $results[$i]->total_points }}</td>
                        </tr>
                    @endfor
                </table>
            </div>
        </div>
    @endif
</div>
</body>
</html>
<style>
    .semi-final {
        margin-top: 30px;
    }

    .final {
        margin-top: 40px;
    }

    .champion {
        margin-top: 40px;
    }
</style>
