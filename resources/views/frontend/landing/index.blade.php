@extends('frontend.landing.layouts.default')

@section('content')
<section class="custom-bnr">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active"> <img class="d-block w-100 img-fluid" src="{{ asset('landing/images/banner-1.jpg') }}" alt="First slide">
              <div class="container">
                <div class="col-md-7 col-sm-12 float-md-right">
                  <div class="carousel-caption dp-caption">
                    <h1>Plagiarism multichecker</h1>
                    <p>Check paper for plagiarism with all most popular anti-plagiarism softwares</p>
                </div>
                </div>
              </div>
            </div>
          </div>
          <!--
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      --> 
        </div>
      </section>
      <section class="cheque-paper">
          <div class="container">
          <div class="row">
              <div class="col-md-12">
              <h5>Don't worry, your writing won't be searchable publicly. </h5> 
                  <h2>Try how this plagiarism multichecker works</h2>
              </div>
          </div>
          @include('frontend.landing.layouts.file-upload')
          </div>
      </section>
      <section class="brand-custom">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <ul>
                              <li><img src="{{ asset('landing/images/brand-1.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-2.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-3.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-4.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-5.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-6.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-7.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-8.png')}}" class="img-fluid" alt=""></li>
                              <li><img src="{{ asset('landing/images/brand-9.png')}}" class="img-fluid" alt=""></li>
                      </ul>
                  </div>
              </div>
          </div>
      </section>
      
      <section class="custom-tools" style="background-image: url( '{{ asset('landing/images/abt-1-bg.jpg') }}');">
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                      <div class="tools-content">
                          <h3>Multi-Checker Plagiarism Checking Tool</h3>
                          <p>Detect plagiarism and copied content using all available plagiarism checkers that can be found on Google. Confirm originality with a multi-checker tool with higher accuracy and speed to achieve authenticity in just a few seconds.</p>
                          <ul>
                              <li><span><i class="fas fa-check"></i></span> <strong>1.	For Students - </strong> Hunt allows students to check their academic papers and assignments for unintentional plagiarism and to ensure the authenticity of their work. Make sure that you submit original work to receive better grades.</li>
                              
                              <li><span><i class="fas fa-check"></i></span> <strong>2.	For Teachers - </strong> Being a teacher, Plagiarism Hunt allows you to check your students' academic papers as well as your own research papers. Detect plagiarism from documents and content that has been already published. </li>
                              
                              <li><span><i class="fas fa-check"></i></span> <strong>3.	For Business - </strong>The standard chunk of Lorem Ipsum used since the 1500s is reproduced randomised words which don't look even slightly believable.</li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="tools-img">
                          <img src="{{ asset('landing/images/abt-1-img.png')}}" class="img-fluid" alt="">
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <section class="custom-marketing">
          <div class="container">
              <div class="row">
                  <div class="col-md-6">
                      <div class="marketing-img">
                          <img src="{{ asset('landing/images/abt-2-img.png')}}" class="img-fluid" alt="">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="custom-marketing-content" id = "about-section">
                          <h5>ALWAYS IN THE RIGHT</h5>
                          <h2>About Plagiarism Hunt</h2>
                          <p>Find similar and paraphrased content using the multi-checker technology and leave no stone unturned to validate the authenticity of your work. Get the best results immediately from all plagiarism checkers available on Google, on a different kind of plagiarism present in your content including similar, related meaning or identical content.</p>
                          <p>Extensive search mechanism and user-friendly interface make Plagiarism Hunt the best option for people who want to authentic their content across all plagiarism tool available on Google. </p>
                          <p>Compare your research papers, assignments, blogs and websites with content that is easily available on the web, and verify the authenticity of your work in terms of originality by comparing content from different repositories.</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      
      <section class="business-help">
          <div class="container">
              <div class="row">
                  <div class="col-md-5 order-md-1">
                      <div class="business-help-img">
                          <img src="{{ asset('landing/images/how-img-1.png')}}" class="img-fluid" alt="">
                      </div>
                  </div>
                  <div class="col-md-7">
                  <div class="business-help-content">
                      <h2>What is Plagiarism?</h2>
                      <p>Plagiarism is considered an act of stealing someone else's work, without providing them the credit that they deserve. When it comes to academic, plagiarism is a serious offense and refers to the process of one student submitting another student's work, under their name. Over the years, submission of plagiarized content for academic and business purposes has increased, and thus a number of different plagiarism checkers have been launched. </p>
                      
                  </div>
                  </div>
                  
              </div>
          </div>
      </section>
      
      <section class="how-palgarism">
          <div class="container">
              <div class="row">
                  <div class="col-md-5">
                      <div class="how-palgarism-img">
                          <img src="{{ asset('landing/images/how-img-2.png')}}" class="img-fluid" alt="">
                      </div>
                  </div>
                  <div class="col-md-7">
                  <div class="how-palgarism-content" id="features-section">
                      <h2>Features of Plagiarism Hunt </h2>
                      
                      <ul>
                          <li><span><i class="fas fa-share"></i></span><strong>1. Cross-Platform Compatibility</strong><br/>
                              <p>   Plagiarism Hunt can be used on any personal computer using Windows, Mac and other mobile devices. </p>
                          </li>
                          
                          <li><span><i class="fas fa-share"></i></span><strong>3. Higher Accuracy</strong><br/>
                              <p>   Plagiarism Hunt scans your files and content with all plagiarism checkers available online, thus providing comprehensive plagiarism reports. </p>
                          </li>
                          
                          <li><span><i class="fas fa-share"></i></span><strong>4. Multiple File Format</strong><br/>
                              <p>   Plagiarism Hunt supports multiple file format. You can submit the content for plagiarism checking using .doc / .docx / .pdf / .txt. </p>
                          </li>
                          <li><span><i class="fas fa-share"></i></span><strong>5. Protecting Content </strong><br/>
                              <p>   When you upload your files or content, Plagiarism Hunt only uses it to check for plagiarism. It is not saved or stored on our database. </p>
                          </li>
                          <li><span><i class="fas fa-share"></i></span><strong>6. Percentage Results </strong><br/>
                              <p>   Plagiarism Hunt offers a percentage of results based on the originality of the document. If the plagiarized percentage is higher, you will know exactly where to make changes.  </p>
                          </li>
                          <li><span><i class="fas fa-share"></i></span><strong>7. Unlimited Paid Reports </strong><br/>
                              <p>   Paid users get access to all the reports from all available plagiarism checker that can be found on Google. You can look at any report that you want.  </p>
                          </li>
                      </ul>
                  </div>
                  </div>
              </div>
          </div>
      </section>
      <section class="custom-graph" style="background-image: url( '{{ asset('landing/images/3-bg.png') }}');">
          <div class="container">
              <div class="row">
              <div class="col-md-12">	
                  <h3>How does it work?</h3>
                  <p>An all in one plagiarism multi-checker tool is the only thing you need to ensure that all of your work is authentic and free from any kind of unintentional plagiarized content. No need to check the content several times at different plagiarism tools available on the internet. </p>
              </div>	
                      <div class="col-md-12 col-lg-12">
                      <ul>
                      <li><strong>1. Upload Paper –</strong> Start by attaching a document from your computer or simply paste the content into the box, to check for copied content absolutely free. </li>
                      
                      <li><strong>2. Plagiarism Detection -</strong> Plagiarism Hunt scans your file or content for any copied data and returns the percentage of plagiarism for the first 3 plagiarism checking tools.</li>
                      
                      <li><strong>3. Detailed Report -</strong> You can avail the most plagiarized content report for a specified amount, and make any necessary correction to make it plagiarism free.</li>
                      
                      <li><strong>4. Multi-Checker -</strong>You can check your files and content with all available plagiarism checkers on Google, by paying a specified amount. You can open any report from any plagiarism checker of your choice. </li>
                  </ul>
                  </div>
                  <div class="col-md-12 col-lg-3"></div>
                              
              </div>
          </div>
      </section>
      <section class="plaga-cheque">
          <div class="container">
              <div class="row">
                  <div class="col-md-7">
                  <div class="plaga-cheque-content" id="contact-section">
                      <h2>Contact Us </h2>
                      <p>Plagiarism Hunt is committed to serving you better. Do you have any questions that need to be answered? Do not hesitate to get in touch with our dedicated team of customer support. Our customer-centric support team is focused on exceeding and surpassing your expectations. <br/>If you have any questions relating to pricing or need assistance with plagiarism checker - get in touch with one of our experts and we will be happy to assist you. You can reach out to us by using the contact form below and/or by email and phone. We are looking forward to hearing from you and answer all the questions necessary. </p>
                      
                  </div>
                  </div>
                  <div class="col-md-5">
                      <div class="plaga-cheque-img">
                          <img src="{{ asset('landing/images/cheaker-img.png')}}" class="img-fluid" alt="">
                      </div>
                  </div>
              </div>
          </div>
      </section>
@stop