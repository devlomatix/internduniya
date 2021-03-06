<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Corporate;
use App\Models\Intenship;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\SubscriptionEvent;
use App\Models\FavouriteInternship;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        
        if(!$user){
            abort(404);
        }

        if($user->role == 'corporate'){
            //return 'University Home';
            return redirect() ->route('company.home');
        }else{
            return redirect() ->route('student.home');
        }
        

    }
    public function home(Request $request)
    {
        $internships = Intenship::orderby('created_at','desc')
                                ->where('status',true)
                                ->where('approved',true)
                                ->take(10)
                                ->get();

        $reviews = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'reviews');
        })->get();

        $blogs = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'blogs');
        })->get();

        $internship_category = Category::where('slug','internship-categories')->first();
        $categories = Category::where('parent_id', $internship_category->id )->where('favourite',true)->orderby('created_at','desc')->get();

        $internship_cities = Category::where('slug','internship-cities')->first();
        $cities = Category::where('parent_id', $internship_cities->id )->orderby('created_at','desc')->get();

        //dd($cities);

        $corporates = Corporate::orderby('created_at','desc')->where('status',true)->get();
        return view('client.pages.home')->with('internships',$internships)
                                        ->with('corporates',$corporates)
                                        ->with('reviews',$reviews)
                                        ->with('blogs',$blogs)
                                        ->with('cities',$cities)
                                        ->with('categories',$categories);
    }

    public function blogs()
    {
        $posts = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'blogs');
        })->paginate(10);

        //dd($posts);

        $random_blogs = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'blogs');
        })->where('status','published')->limit(5)->get();


        //$randomPosts
        return view('client.pages.blogs')->with('posts',$posts)
                                        ->with('random_blogs',$random_blogs);
    }

    public function blog_detail($slug)
    {
        $blog = Post::where('slug',$slug)->where('status','published')->first();
        $random_blog = Post::inRandomOrder()->limit(5)->get();

        $random_blog = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'blogs');
        })->where('status','published')->limit(5)->get();
        
        return view('client.pages.blog_detail')->with('blog',$blog)->with('random_blog',$random_blog);
    }

    public function about()
    {

        return view('client.pages.about');
    }

    public function contact()
    {

        return view('client.pages.contact');
    }

    public function terms(){

        $terms = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'terms');
        })->first();
        return view('client.pages.terms')->with('terms',$terms);
    }

    public function privacy(){

        $privacy = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'privacy');
        })->first();

        


        return view('client.pages.privacy')->with('privacy',$privacy);
    }

    public function subscribe(Request $request)
    {
        $subscription = New Subscription;
        $subscription->email = $request->email;
        $subscription->save();

        //$response = new Response('Hello world');
        //$response->withCookie(cookie('subscription','subscription',10));

        event(new SubscriptionEvent($request));


        return redirect() ->route('app.home')->withCookie(cookie('subscription','subscription',10));
    }

    public function internships($category){
        $internship_cities = Category::where('slug','internship-cities')->first();
        $cities = Category::where('parent_id', $internship_cities->id )->orderby('created_at','desc')->get();


        if($category == 'all'){
            $internships = Intenship::orderby('created_at','desc')
                                ->where('status',true)
                                ->where('approved',true)
                                ->paginate(10);
        }else{
            $internship_category = Category::where('slug',$category)->first();
            $internships = $internship_category->internships()->paginate(10);
        }
        //dd($category);
        return view('client.pages.internships')->with('internships',$internships)->with('cities',$cities);
    }

    public function add_favourite_internship($id){

        //dd($id);
        //$user = auth()->user();

        
        $user = User::findOrFail(auth()->user()->id);
        //dd($user);
        //$user->favourite_internship()->sync($id);
        $favouriteInternship = New FavouriteInternship;
        $favouriteInternship->user_id = auth()->user()->id;
        $favouriteInternship->intenship_id = $id;
        $favouriteInternship->save();

        return redirect()->back()
        ->with([
            'message'    =>'Added to your favourite list',
            'alert-type' => 'success',
        ]);
    }

    public function detail_internship($id){

        //dd($id);
        $internship = Intenship::findOrFail($id);
        //$internship = Intenship::where('slug',$slug)->first();
        
        return view('client.pages.internship_details')->with('internship',$internship);
    }

    public function cookie_consent()
    {
        return redirect()->back()->withCookie(cookie('cookie_consent','cookie_consent',(365 * 24 * 60)));
    }

    public function search_internships(Request $request){

        $search_title = $request->input('title');
        $search_city = $request->input('city');

        //dd($search_title);

        $internship_cities = Category::where('slug','internship-cities')->first();
        $cities = Category::where('parent_id', $internship_cities->id )->orderby('created_at','desc')->get();


        

        if($search_title){
            $internships = Intenship::orderby('created_at','desc')
                                ->where('title', 'like', "%$search_title%")
                                ->orWhere('description', 'like', "%$search_title%")
                                ->orWhere('city', $search_city)
                                ->where('status',true)
                                ->where('approved',true)
                                ->paginate(10);

        }elseif($search_city){

            $internships = Intenship::orderby('created_at','desc')
                                ->where('title', 'like', "%$search_title%")
                                ->orWhere('description', 'like', "%$search_title%")
                                ->orWhere('city', $search_city)
                                ->where('status',true)
                                ->where('approved',true)
                                ->paginate(10);
        }

        if(!$search_title && !$search_city){
            $internships = Intenship::orderby('created_at','desc')
                                ->where('approved',true)
                                ->paginate(10);
        }

        //$internships = Intenship::where('title', 'like', "%$search_title%")->paginate(10);
        //dd($internships);

        return view('client.pages.internships_search_result')->with('internships',$internships)->with('cities',$cities);
    }

    public function subscription_plans(){
        $corporate_plans = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'corporate-plans');
        })->get();

        $student_plans = Post::whereHas('categories', function($q)
        {
            $q->where('slug', '=', 'student-plans');
        })->get();

        
        return view('client.pages.subscription_plans')->with('corporate_plans',$corporate_plans)->with('student_plans',$student_plans);
    }
}
