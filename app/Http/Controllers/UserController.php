<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\User;
use App\Models\UserJob;

class UserController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers(){
        $users = User::all();
        return response()->json(['data' => $users]);
    }        

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);

        // Validate if jobid exists in tbluserjob
        $userjob = UserJob::findOrFail($request->jobid);

        // Create user
        $user = User::create($request->all());

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->errorResponse("User not found", 404);
        }

        return $this->successResponse($user, 200);
    }

    public function update(Request $request, $id)
{
    $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        'gender' => 'in:Male,Female',
        'jobid' => 'required|numeric|min:1|not_in:0',
    ];

    $this->validate($request, $rules);

    // Validate if jobid exists in tbluserjob
    $userjob = UserJob::findOrFail($request->jobid);

    $user = User::findOrFail($id);
    $user->fill($request->all());

    // If no changes happen, return error
    if ($user->isClean()) {
        return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $user->save();

    return $this->successResponse($user);
}        

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}