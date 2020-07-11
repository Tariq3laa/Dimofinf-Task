<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
{
    public function __construct( ) {
        $this->middleware('auth') ;
    }

    public function index() {
        try {
            $companies = Company::select('id', 'name', 'email', 'url', 'logo')->orderBy('id', 'desc')->paginate(10);
            return view('company.index', ['companies'=>$companies]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function create() {
        try {
            return view('company.create');
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function store(Request $request) {
        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:companies',
            'url'       => 'required|url',
            'logo'      => 'required|image',
        ];

        $this->validate(request(), $rules, [], []);

        $image = $request->file('logo');
        $path    = (string) Str::uuid().".".$image->getClientOriginalExtension();

        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(100, 100);
        $image_resize->save(storage_path("app\/public\/".$path));

        $to_name = $request->input('name');
        $to_email = $request->input('email');
        $data = [
            'name'=> $request->input('name'),
            "body" => "Your company entered to the administration level user"
        ];

        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                    ->subject('Management System');
            $message->from('ta11013997@gmail.com','Tarek Alaa');
        });

        Company::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'url' => $request->input('url'),
            'logo' => $path,
        ]);

        return redirect()->route('company.index', app()->getLocale());
    }

    public function edit($locale, Company $company) {
        try {
            return view('company.edit', ['company'=>$company]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function update(Request $request, $locale, Company $company) {
        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:companies,email,'.$company->id.',id',
            'url'       => 'required|url',
            'logo'      => 'image',
        ];

        $this->validate(request(), $rules, [], []);

        if ($request->has('logo')) {
            unlink(storage_path("app/\public\/".$company->logo));

            $image = $request->file('logo');
            $path    = (string) Str::uuid().".".$image->getClientOriginalExtension();

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(100, 100);
            $image_resize->save(storage_path("app\/public\/".$path));

            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->url = $request->input('url');
            $company->logo = $path;
            $company->save();
        } else {
            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->url = $request->input('url');
            $company->save();
        }

        return redirect()->route('company.index', app()->getLocale());
    }

    public function destroy($locale, Company $company) {
        try {
            $company->delete();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function trashed() {
        try {
            $companies = Company::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
            return view('company.trashed', ['companies'=> $companies]);
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function restore($locale, $id) {
        try {
            Company::onlyTrashed()->where('id', $id)->restore();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }

    public function forceDelete($locale, $id) {
        try {
            $logo = Company::onlyTrashed()->where('id', $id)->value('logo');
            unlink(storage_path("app/\public\/".$logo));
            Company::onlyTrashed()->where('id', $id)->forceDelete();
            return back();
        } catch (\Throwable $th) {
            return redirect()->back()
            ->withErrors("Error occured try again");
        }
    }
}
